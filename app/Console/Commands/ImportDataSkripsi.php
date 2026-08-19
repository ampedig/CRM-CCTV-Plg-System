<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ImportDataSkripsi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data-skripsi {--start= : Start ID to process} {--end= : End ID to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import fake customer and transaction data from data-skripsi.csv';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvPath = base_path('data-skripsi.csv');
        if (!file_exists($csvPath)) {
            $this->error("File data-skripsi.csv not found at: {$csvPath}");
            return;
        }

        $startId = $this->option('start');
        $endId = $this->option('end');

        $this->info("Loading products from database...");
        $allProducts = Product::with('category')->where('is_active', 1)->get();
        if ($allProducts->isEmpty()) {
            $this->error("No active products found in the database. Cannot create transactions.");
            return;
        }

        $faker = Faker::create('id_ID');
        $handle = fopen($csvPath, 'r');
        
        // Skip header
        fgetcsv($handle);
        
        $this->info("Starting import...");

        DB::beginTransaction();
        try {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Csv Mapping
                // 0: ID_Pelanggan, 1: Tahun, 2: Umur, 3: Pekerjaan, 4: Jumlah_Chat
                // 5: Frekuensi_Konsultasi, 6: Kunjungan_Website, 7: Nilai_Transaksi
                // 8: Frekuensi_Pembelian, 9: Produk_Diminati, 10: Status_Pembayaran, 11: Lead_Scoring
                
                $idPelanggan = (int)$data[0];
                
                if ($startId && $idPelanggan < (int)$startId) continue;
                if ($endId && $idPelanggan > (int)$endId) continue;

                $tahun = (int)$data[1];
                $umur = (int)$data[2];
                $pekerjaan = $data[3];
                $jumlahChat = (int)$data[4];
                $frekuensiKonsultasi = (int)$data[5];
                $kunjunganWeb = (int)$data[6];
                $nilaiTransaksi = (float)$data[7];
                $frekuensiPembelian = (int)$data[8];
                $produkDiminati = $data[9];
                $statusPembayaranCsv = $data[10];
                $leadScoring = $data[11];
                
                $this->info("Processing CSV ID: {$idPelanggan}");

                // 1. Create Customer
                // [TRIK UMUR AKURAT SAAT EXPORT]
                // Karena Laravel export menggunakan ->age (relatif terhadap hari ini: 2026),
                // maka tahun lahir harus dihitung dari TAHUN SAAT INI dikurang umur CSV.
                // Kita juga set bulan ke 1-7 (Januari-Juli) agar ulang tahunnya sudah lewat sebelum bulan ini (Agustus).
                // Dengan begini umurnya pasti pas dan tanggal/bulan lahirnya tetap bervariasi!
                $birthYear = now()->year - $umur;
                $dob = Carbon::createFromDate($birthYear, rand(1, 7), rand(1, 28));
                
                $createdAt = Carbon::createFromDate($tahun, rand(1, 10), rand(1, 28))->setTime(rand(8,17), rand(0,59), rand(0,59));

                $nameType = rand(1, 10);
                if ($nameType <= 5) {
                    $fullName = $faker->firstName; // 50% 1 kata
                } elseif ($nameType <= 8) {
                    $fullName = $faker->firstName . ' ' . $faker->lastName; // 30% 2 kata
                } else {
                    $fullName = $faker->firstName . ' ' . $faker->firstName . ' ' . $faker->lastName; // 20% 3 kata
                }

                $customer = Customer::create([
                    'full_name' => $fullName,
                    'whatsapp_number' => '628' . $faker->numerify('##########'),
                    'occupation' => $pekerjaan,
                    'date_of_birth' => $dob->format('Y-m-d'),
                    'total_chats_received' => $jumlahChat,
                    'consultation_frequency' => $frekuensiKonsultasi,
                    'last_consultation_at' => (rand(0,1) ? $createdAt->copy()->addDays(rand(1, 30)) : null),
                    'web_visit_count' => $kunjunganWeb,
                    'transaction_count' => $frekuensiPembelian,
                    'total_transaction_value' => 0, // Will be updated correctly after creating tx
                    'last_product_interest' => null, // Will be updated dynamically
                    'lead_score_status' => $leadScoring,
                    'is_active' => 1,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // 2. Create Transactions
                $remainingValue = $nilaiTransaksi;
                $accumulatedValue = 0;

                for ($i = 1; $i <= $frekuensiPembelian; $i++) {
                    $isLastTransaction = ($i === $frekuensiPembelian);
                    $txDate = $createdAt->copy()->addDays(rand(1, 60) * $i); 
                    
                    // Default semua transaksi sebelumnya 'Lunas' (paid). 
                    // Jika CSV bilang 'Belum', maka HANYA transaksi terakhir yang di-set 'Belum' (pending).
                    $currentPaymentStatus = 'paid';
                    if ($isLastTransaction && strtolower(trim($statusPembayaranCsv)) !== 'lunas') {
                        $currentPaymentStatus = 'pending';
                    }

                    $transaction = Transaction::create([
                        'customer_id' => $customer->id,
                        'transaction_date' => $txDate->format('Y-m-d'),
                        'payment_status' => $currentPaymentStatus,
                        'grand_total' => 0,
                        'created_at' => $txDate,
                        'updated_at' => $txDate,
                    ]);

                    // Calculate target subtotal for this specific transaction
                    if ($isLastTransaction) {
                        $targetValue = max(0, $remainingValue);
                    } else {
                        $avgRemaining = $remainingValue / ($frekuensiPembelian - $i + 1);
                        $targetValue = rand(max(10000, $avgRemaining * 0.8), $avgRemaining * 1.2);
                    }

                    $firstProductMatched = false;
                    $currentTxTotal = 0;
                    $detailsData = [];

                    // Greedily fill the transaction cart with products based on real price
                    while ($currentTxTotal < $targetValue) {
                        $product = null;

                        if ($isLastTransaction && !$firstProductMatched) {
                            // Cari produk sesuai minat, yang harganya masih masuk akal (maksimal 1.5x dari target transaksi)
                            $matchedProducts = $allProducts->filter(function($p) use ($produkDiminati, $targetValue) {
                                $match = ($p->category && strtolower(trim($p->category->name)) === strtolower(trim($produkDiminati))) || 
                                         (strtolower(trim($p->name)) === strtolower(trim($produkDiminati)));
                                return $match && $p->price <= max(100000, $targetValue * 1.5);
                            });
                            
                            if ($matchedProducts->isEmpty()) {
                                // Fallback jika tidak ada yang murah, cari tanpa limit harga
                                $matchedProducts = $allProducts->filter(function($p) use ($produkDiminati) {
                                    return ($p->category && strtolower(trim($p->category->name)) === strtolower(trim($produkDiminati))) || 
                                           (strtolower(trim($p->name)) === strtolower(trim($produkDiminati)));
                                });
                            }

                            if ($matchedProducts->isNotEmpty()) {
                                $product = $matchedProducts->random();
                            } else {
                                $product = $allProducts->random(); // Fallback paling akhir
                            }
                            $firstProductMatched = true;
                        } else {
                            // Pilih produk acak, TAPI harus yang harganya masuk akal (tidak overbudget)
                            $affordableProducts = $allProducts->filter(fn($p) => $p->price <= max(100000, $targetValue * 1.2));
                            if ($affordableProducts->isEmpty()) {
                                $affordableProducts = $allProducts;
                            }
                            $product = $affordableProducts->random();
                        }

                        $remainingForThisItem = $targetValue - $currentTxTotal;
                        $maxQty = floor($remainingForThisItem / max(1, $product->price));

                        if ($maxQty < 1) {
                            // Produk terlalu mahal untuk sisa target.
                            if ($currentTxTotal == 0) {
                                $qty = 1; // Paksa beli 1 jika keranjang masih kosong
                            } else {
                                break; // Jika keranjang sudah ada isi, stop tambah barang mahal ini
                            }
                        } else {
                            // Agar keranjang bervariasi (banyak jenis produk), jangan habiskan budget di 1 barang
                            // Ambil Qty secara acak (1 sampai 3), kecuali ini random 20% terakhir langsung dihabiskan
                            if (rand(1, 100) > 80) {
                                $qty = $maxQty;
                            } else {
                                $qty = rand(1, min(3, $maxQty));
                            }
                        }

                        $subTotal = $qty * $product->price;
                        
                        $detailsData[] = [
                            'product_id' => $product->id,
                            'quantity' => $qty,
                            'sub_total' => $subTotal,
                            'product_model' => $product, // Simpan reference untuk update profil nanti
                        ];

                        $currentTxTotal += $subTotal;
                        
                        if ($currentTxTotal >= $targetValue) {
                            break;
                        }
                    }

                    // [TRIK AKURASI 100% CSV] 
                    // Jika ini adalah transaksi penutup dari pelanggan tersebut,
                    // kita paksa (manipulasi) sub_total dari produk terakhir agar grand_total-nya sama persis dengan CSV
                    if ($isLastTransaction && count($detailsData) > 0) {
                        $exactTargetForTx = max(0, $remainingValue);
                        $diff = $exactTargetForTx - $currentTxTotal;
                        
                        $lastIndex = count($detailsData) - 1;
                        $detailsData[$lastIndex]['sub_total'] += $diff;

                        // Pastikan tidak ada sub_total yang minus akibat pengurangan
                        for ($k = $lastIndex; $k >= 0; $k--) {
                            if ($detailsData[$k]['sub_total'] < 0) {
                                $minus = $detailsData[$k]['sub_total'];
                                $detailsData[$k]['sub_total'] = 0; // Jadikan 0 (seolah bonus/diskon 100%)
                                if ($k > 0) {
                                    $detailsData[$k-1]['sub_total'] += $minus; // Bebankan minus ke item sebelumnya
                                }
                            }
                        }
                        
                        $currentTxTotal = $exactTargetForTx;
                    }

                    // Insert ke database setelah data matang
                    foreach ($detailsData as $detail) {
                        TransactionDetail::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $detail['product_id'],
                            'quantity' => $detail['quantity'],
                            'sub_total' => $detail['sub_total'],
                            'created_at' => $txDate,
                            'updated_at' => $txDate,
                        ]);
                    }

                    // Update actual total
                    $transaction->update(['grand_total' => $currentTxTotal]);
                    
                    // Simulate dynamic last_product_interest update logic from TransactionController
                    if (count($detailsData) > 0) {
                        $prod = $detailsData[0]['product_model'];
                        $catName = $prod->category ? $prod->category->name : $prod->name;
                        $customer->update(['last_product_interest' => $catName]);
                    }

                    $remainingValue -= $currentTxTotal;
                    $accumulatedValue += $currentTxTotal;
                }
                
                // Finalize accurate sum value
                $customer->update(['total_transaction_value' => $accumulatedValue]);
            }
            
            DB::commit();
            $this->info("Import completed successfully!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error occurred: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
        }
        
        fclose($handle);
    }
}

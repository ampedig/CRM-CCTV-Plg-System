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

class ImportDataTambahan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data-tambahan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import 200 random additional customers (Dec 2025 - Jul 2026)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvPath = base_path('data-tambahan-200.csv');
        if (!file_exists($csvPath)) {
            $this->error("File data-tambahan-200.csv not found at: {$csvPath}");
            return;
        }

        $this->info("Loading active products from database...");
        $allProducts = Product::with('category')->where('is_active', 1)->get();
        if ($allProducts->isEmpty()) {
            $this->error("No active products found in the database. Cannot create transactions.");
            return;
        }

        $faker = Faker::create('id_ID');
        $handle = fopen($csvPath, 'r');
        
        // Skip header
        fgetcsv($handle);
        
        $this->info("Starting import of 200 data...");

        DB::beginTransaction();
        try {
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // CSV Mapping:
                // 0: ID_Pelanggan, 1: Nama, 2: Tahun, 3: Umur, 4: Pekerjaan, 5: Jumlah_Chat
                // 6: Frekuensi_Konsultasi, 7: Kunjungan_Website, 8: Nilai_Transaksi
                // 9: Frekuensi_Pembelian, 10: Produk_Diminati, 11: Status_Pembayaran
                
                $idPelanggan = (int)$data[0];
                $namaCsv = $data[1];
                $umur = (int)$data[3];
                $pekerjaan = $data[4];
                $jumlahChat = (int)$data[5];
                $frekuensiKonsultasi = (int)$data[6];
                $kunjunganWeb = (int)$data[7];
                $nilaiTransaksi = (float)$data[8];
                $frekuensiPembelian = (int)$data[9];
                $produkDiminati = $data[10];
                $statusPembayaranCsv = $data[11];
                
                $this->info("Processing Tambahan ID: {$idPelanggan}");

                // Tanggal random dari 1 Des 2025 - 31 Jul 2026
                $startTimestamp = Carbon::create(2025, 12, 1, 8, 0, 0)->timestamp;
                $endTimestamp = Carbon::create(2026, 7, 31, 17, 0, 0)->timestamp;
                $createdAt = Carbon::createFromTimestamp(rand($startTimestamp, $endTimestamp));

                // Umur
                $birthYear = now()->year - $umur;
                $dob = Carbon::createFromDate($birthYear, rand(1, 7), rand(1, 28));
                
                // Nama
                $fullName = $namaCsv;

                // Nomor WA
                $prefixes = ['811', '812', '813', '821', '822', '823', '852', '853', '851', '814', '815', '816', '855', '856', '857', '858', '817', '818', '819', '859', '877', '878', '831', '832', '838', '895', '896', '897', '898', '899', '881', '882', '883', '884', '885', '886', '887', '888', '889'];
                $selectedPrefix = $prefixes[array_rand($prefixes)];
                $suffixLength = rand(7, 9); 
                $suffix = '';
                for ($k = 0; $k < $suffixLength; $k++) {
                    $suffix .= rand(0, 9);
                }
                $validWhatsApp = '62' . $selectedPrefix . $suffix;

                // Create Customer
                $customer = Customer::create([
                    'full_name' => $fullName,
                    'whatsapp_number' => $validWhatsApp,
                    'occupation' => $pekerjaan,
                    'date_of_birth' => $dob->format('Y-m-d'),
                    'total_chats_received' => $jumlahChat,
                    'consultation_frequency' => $frekuensiKonsultasi,
                    'last_consultation_at' => (rand(0,1) ? $createdAt->copy()->addDays(rand(1, 30)) : null),
                    'web_visit_count' => $kunjunganWeb,
                    'transaction_count' => $frekuensiPembelian,
                    'total_transaction_value' => 0, 
                    'last_product_interest' => null, 
                    'is_active' => 1,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Create Transactions
                $remainingValue = $nilaiTransaksi;
                $accumulatedValue = 0;

                for ($i = 1; $i <= $frekuensiPembelian; $i++) {
                    $isLastTransaction = ($i === $frekuensiPembelian);
                    $txDate = $createdAt->copy()->addDays(rand(1, 15) * $i); 
                    
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

                    if ($isLastTransaction) {
                        $targetValue = max(0, $remainingValue);
                    } else {
                        $avgRemaining = $remainingValue / ($frekuensiPembelian - $i + 1);
                        $targetValue = rand(max(10000, $avgRemaining * 0.8), $avgRemaining * 1.2);
                    }

                    $firstProductMatched = false;
                    $currentTxTotal = 0;
                    $detailsData = [];

                    while ($currentTxTotal < $targetValue) {
                        $product = null;

                        if ($isLastTransaction && !$firstProductMatched) {
                            $matchedProducts = $allProducts->filter(function($p) use ($produkDiminati, $targetValue) {
                                $match = ($p->category && strtolower(trim($p->category->name)) === strtolower(trim($produkDiminati))) || 
                                         (strtolower(trim($p->name)) === strtolower(trim($produkDiminati)));
                                return $match && $p->price <= max(100000, $targetValue * 1.5);
                            });
                            
                            if ($matchedProducts->isEmpty()) {
                                $matchedProducts = $allProducts->filter(function($p) use ($produkDiminati) {
                                    return ($p->category && strtolower(trim($p->category->name)) === strtolower(trim($produkDiminati))) || 
                                           (strtolower(trim($p->name)) === strtolower(trim($produkDiminati)));
                                });
                            }

                            if ($matchedProducts->isNotEmpty()) {
                                $product = $matchedProducts->random();
                            } else {
                                $product = $allProducts->random();
                            }
                            $firstProductMatched = true;
                        } else {
                            $affordableProducts = $allProducts->filter(fn($p) => $p->price <= max(100000, $targetValue * 1.2));
                            if ($affordableProducts->isEmpty()) {
                                $affordableProducts = $allProducts;
                            }
                            $product = $affordableProducts->random();
                        }

                        $remainingForThisItem = $targetValue - $currentTxTotal;
                        $maxQty = floor($remainingForThisItem / max(1, $product->price));

                        if ($maxQty < 1) {
                            if ($currentTxTotal == 0) {
                                $qty = 1;
                            } else {
                                break; 
                            }
                        } else {
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
                            'product_model' => $product,
                        ];

                        $currentTxTotal += $subTotal;
                        
                        if ($currentTxTotal >= $targetValue) {
                            break;
                        }
                    }

                    if ($isLastTransaction && count($detailsData) > 0) {
                        $exactTargetForTx = max(0, $remainingValue);
                        $diff = $exactTargetForTx - $currentTxTotal;
                        
                        $lastIndex = count($detailsData) - 1;
                        $detailsData[$lastIndex]['sub_total'] += $diff;

                        for ($k = $lastIndex; $k >= 0; $k--) {
                            if ($detailsData[$k]['sub_total'] < 0) {
                                $minus = $detailsData[$k]['sub_total'];
                                $detailsData[$k]['sub_total'] = 0; 
                                if ($k > 0) {
                                    $detailsData[$k-1]['sub_total'] += $minus; 
                                }
                            }
                        }
                        
                        $currentTxTotal = $exactTargetForTx;
                    }

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

                    $transaction->update(['grand_total' => $currentTxTotal]);
                    
                    if (count($detailsData) > 0) {
                        $prod = $detailsData[0]['product_model'];
                        $catName = $prod->category ? $prod->category->name : $prod->name;
                        $customer->update(['last_product_interest' => $catName]);
                    }

                    $remainingValue -= $currentTxTotal;
                    $accumulatedValue += $currentTxTotal;
                }
                
                $customer->update(['total_transaction_value' => $accumulatedValue]);

                // Auto calculate lead score because it's ID > 500
                $customer->updateLeadScore();

                $count++;
            }
            
            DB::commit();
            $this->info("Successfully imported {$count} additional data!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error occurred: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
        }
        
        fclose($handle);
    }
}

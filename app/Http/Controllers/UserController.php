<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan paginasi dan pencarian.
     * Menggunakan clean code dan e-commerce dashboard style.
     */
    public function index(Request $request): View
    {
        // Fitur pencarian berdasarkan nama atau email
        $search = $request->input('search');

        // Mengatur jumlah item per halaman (10, 25, 50, 100), default 10
        $perPage = $request->integer('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('dashboard.users.index', compact('users', 'search'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create(): View
    {
        return view('dashboard.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database dengan validasi ketat.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input form pengguna baru
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::in(['admin', 'sales'])],
        ]);

        // Hashing password sebelum disimpan ke database
        $validated['password'] = Hash::make($validated['password']);

        // Membuat user baru menggunakan mass assignment
        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk pengguna tertentu.
     */
    public function edit(User $user): View
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validasi data yang akan diperbarui
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Abaikan email user ini sendiri saat pengecekan keunikan
            ],
            'password' => ['nullable', 'string', 'min:8'], // Password bersifat opsional saat update
            'role' => ['required', 'string', Rule::in(['admin', 'sales'])],
        ]);

        // Proses password: jika diisi maka di-hash, jika kosong maka dihapus dari array agar tidak menimpa password lama
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update data user
        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     * Dilengkapi proteksi agar tidak bisa menghapus diri sendiri.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Proteksi tingkat tinggi: Mencegah user yang sedang login menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus user dari database
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}

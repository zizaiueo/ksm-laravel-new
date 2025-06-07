<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;
use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_plggn' => 'required|string|max:255',
            'alamat_plggn' => 'required|string',
            'no_hp' => 'required|string|max:20|unique:pelanggans,no_hp',
        ]);

        $pelanggan = Pelanggan::create($request->only(['nama_plggn', 'alamat_plggn', 'no_hp']));

        // Tambahkan ini: buat akun user otomatis
        User::create([
            'username' => $pelanggan->no_hp,
            'password' => Hash::make('password123'), // default password
            'role' => 'customer',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Pelanggan berhasil ditambahkan.',
                'data' => $pelanggan,
            ], 201);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }


    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_plggn' => 'required|string',
            'alamat_plggn' => 'required|string',
            'no_hp' => 'required|string|unique:pelanggans,no_hp,' . $id,
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $oldPhone = $pelanggan->no_hp;

        // Update data pelanggan
        $pelanggan->update([
            'nama_plggn' => $request->nama_plggn,
            'alamat_plggn' => $request->alamat_plggn,
            'no_hp' => $request->no_hp,
        ]);

        // Jika no_hp berubah, update juga user login
        if ($oldPhone !== $request->no_hp) {
            $user = User::where('username', $oldPhone)->first();

            if ($user) {
                $user->username = $request->no_hp;
                $user->save();
            }
        }

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}

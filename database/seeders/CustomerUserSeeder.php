<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelanggan;

class CustomerUserSeeder extends Seeder
{
    public function run()
        {
            $pelanggans = Pelanggan::all();

            foreach ($pelanggans as $pelanggan) {
                // Cek kalau user dengan username sama belum ada
                $userExists = User::where('username', $pelanggan->no_hp)->exists();

                if (!$userExists) {
                    User::create([
                        'username' => $pelanggan->no_hp,
                        'password' => Hash::make('password123'),  // password default
                        'role' => 'customer',
                    ]);
                }
            }
        }
}
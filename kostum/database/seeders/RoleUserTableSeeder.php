<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        // Mendapatkan peran "Admin" dan "User"
        $adminRole = Role::where('title', 'Admin')->first();
        $userRole = Role::where('title', 'User')->first();

        // Pastikan admin pertama hanya mendapatkan peran 'Admin' saja
        $adminUser = User::findOrFail(1);
        $adminUser->roles()->sync([$adminRole->id]);  // Menghapus semua peran lama dan menambahkan peran Admin saja

        // Membuat pengguna biasa (User)
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // Menambahkan peran "User" pada pengguna biasa
        $regularUser->roles()->attach($userRole);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Role
        $roles = ['super_admin', 'admin', 'pemantau', 'penyandang'];
        foreach ($roles as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }

        // Create User
        $dataUser = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@sightway.my.id',
                'password' => bcrypt('superadmin123'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin1@sightway.my.id',
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Pemantau',
                'email' => 'pemantau@gmail.com',
                'password' => bcrypt('pemantau123'),
            ],
            [
                'name' => 'Penyandang Disabilitas',
                'email' => 'penyandang@gmail.com',
                'password' => bcrypt('penyandang123'),
            ]
        ];
        foreach ($dataUser as $key => $user) {
            $user = User::create($user);
            $user->assignRole($roles[$key]);
        }
    }
}

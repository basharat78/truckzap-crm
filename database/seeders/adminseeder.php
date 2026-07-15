<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@truckzap.com',
            'password' => bcrypt('password'), // Change this to a secure password
        ]);
        $user->assignRole('admin');
    }
}

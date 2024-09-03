<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
       // Create Admin
        User::create([
            'name' => 'Ali_Aljendy',
            'email' => 'alialjndy2@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}

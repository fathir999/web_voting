<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@voting.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample Users
        User::create([
            'name' => 'User 1',
            'email' => 'user1@voting.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user2@voting.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Sample Candidates
        Candidate::create([
            'name' => 'Kandidat 1',
            'vision' => 'Membangun pendidikan yang berkualitas untuk semua',
            'mission' => 'Meningkatkan kualitas guru dan fasilitas sekolah',
            'is_active' => true,
        ]);

        Candidate::create([
            'name' => 'Kandidat 2',
            'vision' => 'Kesehatan untuk semua lapisan masyarakat',
            'mission' => 'Menyediakan layanan kesehatan gratis dan berkualitas',
            'is_active' => true,
        ]);

        Candidate::create([
            'name' => 'Kandidat 3',
            'vision' => 'Ekonomi rakyat yang sejahtera',
            'mission' => 'Memberdayakan UMKM dan menciptakan lapangan kerja',
            'is_active' => true,
        ]);
    }
}
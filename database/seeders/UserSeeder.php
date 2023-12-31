<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'name' => 'سید هادی',
            'email' => 'eh.mansoori@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}

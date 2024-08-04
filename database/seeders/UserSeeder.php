<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'Peter Capaldi',
            'email' => 'peter.capaldi@doctorwho.co.uk',
            'location' => 'Glasgow'
        ]);

        DB::table('users')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'Matt Smith',
            'email' => 'matt.smith@doctorwho.co.uk',
            'location' => 'Northampton'
        ]);
    }
}

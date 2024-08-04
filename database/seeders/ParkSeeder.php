<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parks')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'Hyde Park'
        ]);

        DB::table('parks')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'St. James\'s Park'
        ]);

        DB::table('parks')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'Greenwich Park'
        ]);

        DB::table('parks')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'The Green Park'
        ]);
    }
}

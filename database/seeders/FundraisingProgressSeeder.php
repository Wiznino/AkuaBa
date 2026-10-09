<?php

namespace Database\Seeders;

use App\Models\FundraisingProgress;
use Illuminate\Database\Seeder;

class FundraisingProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! FundraisingProgress::query()->exists()) {
            $progress = new FundraisingProgress;
            $progress->id = 1;
            $progress->save();
        }
    }
}

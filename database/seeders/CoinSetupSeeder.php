<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("coin_setups")->insert([
             'post'=>10,
             'comment'=>10,
             'post_limit'=>100,
             'comment_limit'=>100,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'bread_name'=>'クロワッサン',
                'stock'=>5,
                'price'=>100,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
        ]);
    }
}

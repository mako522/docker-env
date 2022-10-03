<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params=[
            [
                'bread_name'=>'クロワッサン',
                'stock'=>5,
                'price'=>100,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ];

        foreach($params as $param){
            DB::table('products')->insert($param);

    }
    }
}

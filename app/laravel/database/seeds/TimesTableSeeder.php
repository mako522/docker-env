<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TimesTableSeeder extends Seeder
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
                'time_name'=>'10:00-11:00',
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ],
        ];

        foreach($params as $param){
            DB::table('times')->insert($param);

        }
    }
}

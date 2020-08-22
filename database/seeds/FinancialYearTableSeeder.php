<?php

use Illuminate\Database\Seeder;
use App\FinancialYear;

class FinancialYearTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinancialYear::truncate();
        $financialYear = [

            'company_id' 	=> 1,
            'name' 		    => '2017-2018',
            'from_date'     => '2017-04-01',
            'to_date'       => '2018-03-31',
            'status'        => 1,
            'created_by'	=> 1,
            'created_at' 	=> new \DateTime,

        ];
        FinancialYear::create($financialYear);
    }
}

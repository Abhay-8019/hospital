<?php

use Illuminate\Database\Seeder;
use App\Hospital;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hospital::truncate();
        $hospital = [
            'company_code'    => 'CP-01',
            'hospital_name'    => 'celec_enterprises',
            'contact_person'   => 'Mr. Lakhwinder',
            'email'            => 'Lakhwinderkumar93@gmail.com',
            'mobile'           => '9316166007',
            'phone'            => '0161-5101145',
            'website'          => 'www.celec.com',
            'city'             => 'Ludhiana',
            'state'            => 'Punjab',
            'country'          => 'INDIA',
            'pincode'          => 141001,
            'timezone'         => 56,
            'status' 		   => 1,
            'created_at' 	   => new \DateTime,
            'updated_at' 	   => new \DateTime

        ];
        Hospital::create($hospital);
    }
}

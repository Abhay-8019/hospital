<?php

/**
 * :: Role Seeder ::
 * To seeding default roles.
 *
 **/

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        $roles = [
            [
                'name' 			=> 'Super Admin',
                'code' 			=> 'SUPADM',
                'status' 		=> 1,
                'company_id'	=> null,
                'isdefault'		=> 1,
                'created_at' 	=> new \DateTime,
                'created_by'	=> 1,

            ],
            [
                'name' 			=> 'Admin',
                'code' 			=> 'ADM',
                'company_id'	=> null,
                'status' 		=> 1,
                'isdefault'		=> 1,
                'created_at' 	=> new \DateTime,
                'created_by'	=> 1,

            ],
            
        ];
        Role::insert($roles);
    }
}

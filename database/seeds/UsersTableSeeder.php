<?php

/**
 * :: User Seeder ::
 * To seeding default users.
 *
 **/

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $user = [
            'username' 		 => 'radmin',
            'email' 		 => 'admin@admin.com',
            'password'       => Hash::make('123456'),
            'name'           => 'Super Admin',
            'role_id'        => 1,
            'is_super_admin' => 1,
            'is_admin'       => 0,
            'status' 		 => 1,
            'created_at' 	 => new \DateTime,
            'updated_at' 	 => new \DateTime
        ];
        User::create($user);

    }
}


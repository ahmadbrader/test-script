<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ananda Bayu',
            'email' => 'bayu@email.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'npp' => '12345',
            'npp_supervisor' => '11111',
        ]);
        
        User::create([
            'name' => 'supervisor',
            'email' => 'spv@email.com',
            'password' => bcrypt('password'),
            'role' => 'spv',
            'npp' => '1111',
            'npp_supervisor' => '-',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            'role_name' => Role::ADMIN,
        ]);

        Role::insert([
            'role_name' => Role::APPROVER,
        ]);

        Role::insert([
            'role_name' => Role::EMPLOYEE,
        ]);
    }
}

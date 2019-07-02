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
            'role_name' => "Admin",
        ]);

        Role::insert([
            'role_name' => "Approver",
        ]);

        Role::insert([
            'role_name' => "Employee",
        ]);
    }
}

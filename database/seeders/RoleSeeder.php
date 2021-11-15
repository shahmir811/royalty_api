<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin = Role::create([
        'name' => 'admin',
        'description' => 'Admin of the whole application'
      ]);

      $admin->save();

      $employee = Role::create([
        'name' => 'employee',
        'description' => 'Gives limited access to whole application'
      ]);

      $employee->save();
    }
}

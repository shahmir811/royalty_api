<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Role::where('name', '=', 'admin')->pluck('id')->first();
        $emp_id = Role::where('name', '=', 'employee')->pluck('id')->first();

        // $user1 = User::create([
        //     'name' => 'Shahmir Khan Jadoon',
        //     'email' => 'shahmir@gmail.com',
        //     'password' =>  bcrypt(123456),
        //     'role_id' => $admin_id,
        // ]);

        // $user1->save();        

        $user2 = User::create([
            'name' => 'Abdul Aziz',
            'email' => 'radwangk@yahoo.com',
            'password' =>  bcrypt(123456),
            'role_id' => $admin_id,
        ]);

        $user2->save();
        
        // $user3 = User::create([
        //     'name' => 'Zafar Khan',
        //     'email' => 'zafar@gmail.com',
        //     'password' =>  bcrypt(123456),
        //     'role_id' => $emp_id,
        // ]);

        // $user3->save();        
    }
}

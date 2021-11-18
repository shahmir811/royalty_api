<?php

namespace Database\Seeders;

use App\Models\{Status};
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $record = Status::create([
            'name' => 'Pending',
            'type' => 'sales'
        ]);

        $record->save();

        $record = Status::create([
            'name' => 'Paid',
            'type' => 'sales'
        ]);

        $record->save();
        
        $record = Status::create([
            'name' => 'Checked',
            'type' => 'sales'
        ]);

        $record->save();
        
        $record = Status::create([
            'name' => 'Delivered',
            'type' => 'sales'
        ]);

        $record->save();
        
        $record = Status::create([
            'name' => 'Cancelled',
            'type' => 'sales'
        ]);

        $record->save();
        
        $record = Status::create([
            'name' => 'Pending',
            'type' => 'purchase'
        ]);

        $record->save();
        
        $record = Status::create([
            'name' => 'Received',
            'type' => 'purchase'
        ]);

        $record->save();        
    }
}

<?php

namespace Database\Seeders;

use App\Models\{PredefinedValue};
use Illuminate\Database\Seeder;

class PredefinedValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $record = PredefinedValue::create([
            'percent' => 5,
            'show_tax' => true,
        ]);

        $record->save();  
    }
}

<?php

namespace Database\Seeders;

use App\Models\{Category};
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat1 = new Category;
        $cat1->name = 'Agricultural Machineries & Equipment';
        $cat1->save();

        $cat1 = new Category;
        $cat1->name = 'Construction Machineries';
        $cat1->save();        

        $cat1 = new Category;
        $cat1->name = 'Digital Scales';
        $cat1->save();

        $cat1 = new Category;
        $cat1->name = 'Gasoline & Diesel Engines';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Gasoline Chain Saw';
        $cat1->save();        

        $cat1 = new Category;
        $cat1->name = 'Power Srayers';
        $cat1->save();

        $cat1 = new Category;
        $cat1->name = 'Solar Panels & Controllers';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Welding Machines & Battery Chargers';
        $cat1->save();        

        $cat1 = new Category;
        $cat1->name = 'Air Compressors';
        $cat1->save();

        $cat1 = new Category;
        $cat1->name = 'Deep Well Submersible Pumps';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Electric High Pressure Washers';
        $cat1->save();        

        $cat1 = new Category;
        $cat1->name = 'Gasoline & Diesel High Pressure Washers';
        $cat1->save();

        $cat1 = new Category;
        $cat1->name = 'Gasoline Generators';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Power Tools';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Solar Batteries';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Aluminium Ladders';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Diesel Generators';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Electric Water Pumps';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Gasoline & Diesel Water Pumps';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Power Inverters';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'PVC Hoses';
        $cat1->save(); 
        
        $cat1 = new Category;
        $cat1->name = 'Solar Submersible Pumps';
        $cat1->save();         
        
    }
}

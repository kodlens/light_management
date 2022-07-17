<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeethSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $data = [
            //maxillary right
            [
                'tooth_name' => 'Maxillary Right Third Molar',
            ],
            [
                'tooth_name' => 'Maxillary Right Second Molar',
            ],
            [
                'tooth_name' => 'Maxillary Right First Molar',
            ],
            [
                'tooth_name' => 'Maxillary Right Second Premolar',
            ],
            [
                'tooth_name' => 'Maxillary Right First Premolar',
            ],
            [
                'tooth_name' => 'Maxillary Right Canine',
            ],
            [
                'tooth_name' => 'Maxillary Right Lateral Incisor',
            ],
            [
                'tooth_name' => 'Maxillary Right Central Incisor',
            ],



            //maxillary left
            [
                'tooth_name' => 'Maxillary Left Central Incisor',
            ],
            [
                'tooth_name' => 'Maxillary Left Lateral Incisor',
            ],
            [
                'tooth_name' => 'Maxillary Left Canine',
            ],
            [
                'tooth_name' => 'Maxillary Left First Premolar',
            ],
            [
                'tooth_name' => 'Maxillary Left Second Premolar',
            ],
            [
                'tooth_name' => 'Maxillary Left First Molar',
            ],
            [
                'tooth_name' => 'Maxillary Left Second Molar',
            ],
            [
                'tooth_name' => 'Maxillary Left Third Molar',
            ],







            //mandibular left
            [
                'tooth_name' => 'Mandibular Left Third Molar',
            ],
             [
                'tooth_name' => 'Mandibular Left Second Molar',
            ],
            [
                'tooth_name' => 'Mandibular Left First Molar',
            ],
            [
                'tooth_name' => 'Mandibular Left Second Premolar',
            ],
            [
                'tooth_name' => 'Mandibular Left First Premolar',
            ],
            [
                'tooth_name' => 'Mandibular Left Canine',
            ],
             [
                'tooth_name' => 'Mandibular Left Lateral Incisor',
            ],
            [
                'tooth_name' => 'Mandibular Left Central Incisor',
            ],

           
            
      
            //mandibular right
            [
                'tooth_name' => 'Mandibular Right Central Incisor',
            ],
            [
                'tooth_name' => 'Mandibular Right Lateral Incisor',
            ],
            [
                'tooth_name' => 'Mandibular Right Canine',
            ],
            [
                'tooth_name' => 'Mandibular Right First Premolar',
            ],
            [
                'tooth_name' => 'Mandibular Right Second Premolar',
            ],
            [
                'tooth_name' => 'Mandibular Right First Molar',
            ],
            [
                'tooth_name' => 'Mandibular Right Second Molar',
            ],
            [
                'tooth_name' => 'Mandibular Right Third Molar',
            ],

           
            
            
            
            
            
           


            

        ];

        \App\Models\Teeth::insertOrIgnore($data);


    }
}

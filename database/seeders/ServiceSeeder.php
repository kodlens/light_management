<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
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
            [
                'service' => 'Dental Bonding',
                'description' => 'Dental bonding is a technique used to correct imperfections with your teeth to give you a better-looking smile. Bonding is used to repair chipped teeth, decayed teeth, and cracked teeth. Bonding involves applying a tooth-colored resin material to the teeth and hardening it with a light. This bonds the material to the teeth to improve a person\'s smile.',
                'price' => 250
            ],
            [
                'service' => 'Dental Crowns',
                'description' => 'A dental crown is a dental prosthesis which replaces the visible part of a tooth. A dental crown functions to strengthen teeth, restore their original shape, and improve their appearance. Dental crowns are also used to hold dental bridges in place and cover dental implants.',
                'price' => 300
            ],
            [
                'service' => 'Bridgework',
                'description' => 'A dental bridge is a structure between two dental crowns to fill the gap between missing teeth. A bridge can be supported by your teeth, implants, or a combination of teeth and implants. A dental bridge can restore your smile, improve your appearance, and take years off your look. Who doesn\'t want to look better- or younger?',
                'price' => 500
            ],
            [
                'service' => 'Cosmetic Fillings',
                'description' => 'Cosmetic fillings, or tooth- colored fillings, are made of composite resin and glass particles. They are cemented onto the existing teeth using a bonding agent. Cosmetic fillings can improve the appearance of your smile. Unlike silver-colored fillings, cosmetic fillings look just like your natural teeth.',
                'price' => 500
            ],
            [
                'service' => 'Invisalign',
                'description' => 'Crooked smile? Invisalign is the best way to straighten your smile without interfering with your day-to-day life. Invisalign gradually moves your teeth using a series of custom-fitted, removable aligners. Invisalign aligners are nearly invisible and very comfortable to wear.',
                'price' => 500
            ],
            [
                'service' => 'Dental Veneers',
                'description' => 'Many people are discovering the benefits of veneers. Veneers are thin coverings that are placed over the front part of the teeth. Veneers are placed on teeth that are crooked, poorly shaped, or severely discolored. They may also be used to lighten teeth that are yellow or have a gray cast.',
                'price' => 500
            ],
            [
                'service' => 'Teeth Cleanings',
                'description' => 'You should visit the dentist every six months for teeth cleanings. Tartar is a hard buildup of plaque that forms on the teeth. Tartar forms below and above the gum line. The only way to remove tartar is to see a dentist for a professional teeth cleaning. Regular teeth cleanings are important to maintaining healthy teeth and gums.',
                'price' => 500
            ],
            [
                'service' => 'Dentures',
                'description' => 'Have you lost most or all of your teeth? Dentures are removable appliances that can replace missing teeth. A complete denture is used when all of the patient\'s teeth are missing. A partial denture is used when only some of the teeth are missing. Today\'s dentures are natural looking and more comfortable than ever.',
                'price' => 500
            ],
            [
                'service' => 'Root Canal Therapy',
                'description' => 'In the past, diseased teeth often had to be extracted. Today, they often can be saved through root canal therapy. A root canal is a dental procedure that is used to repair teeth that are infected or badly decayed. Some people fear root canal treatments because they assume they are painful. Most people report that the procedure is no more painful than having a filling placed.',
                'price' => 500
            ],
            [
                'service' => 'Dental Sealants',
                'description' => 'Sealants are made of plastic and are applied to the chewing surfaces of the back teeth to prevent tooth decay. Sealants are painted on as a liquid and harden to form a shield over the teeth. Having sealants put on your teeth will save you money in the long run by avoiding dental fillings, crowns, and other dental treatments.',
                'price' => 500
            ],
            [
                'service' => 'Teeth Whitening',
                'description' => 'Want a whiter smile? Your main options are at-home and in-office bleaching. At-home teeth whitening involves custom-made dental trays filled with hydrogen peroxide gel that you can use at home. For in-office bleaching, your dentist will combine hydrogen peroxide gel with a light source to speed up the whitening process.',
                'price' => 500
            ],
            [
                'service' => 'Tooth Extractions',
                'description' => 'A tooth extraction, or dental extraction, is the removal of a tooth from its socket in the bone. There are a number of reasons why tooth removal may be necessary. An extraction may be necessary if your tooth is so damaged that it can\'t be fixed with a dental restoration. In some cases, dentists extract teeth to prepare the patient\'s mouth for orthodontic treatment.',
                'price' => 500
            ],

        ];

        \App\Models\Service::insertOrIgnore($data);


    }
}

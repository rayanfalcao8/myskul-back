<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\School;

class SchoolTableSeeder extends Seeder
{
    public function run()
    {
        School::create([
            'name' => 'Faculté de Medecine',
            'display_name' => 'CUSS',
            'country' => 'Cameroon',
        ]);

        School::create([
            'name' => 'Ecole Normale Superieur',
            'display_name' => 'ENS',
            'country' => 'Cameroon',
        ]);

        School::create([
            'name' => 'Faculté de Medecine et des Sciences Pharmaceutique de l\'Université de Douala',
            'display_name' => 'FMSP UD',
            'country' => 'Cameroon',
        ]);

        School::create([
            'name' => 'Université de Yaounde 1',
            'display_name' => 'UY1',
            'country' => 'Cameroon',
        ]);
    }
}

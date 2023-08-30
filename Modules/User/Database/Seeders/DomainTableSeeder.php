<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\Domain;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::create([
            'name' => 'Prepa Concours',
            'display_name' => 'PREPA',
        ]);

        Domain::create([
            'name' => 'Bords Numeriques',
            'display_name' => 'BORDS NUMERIQUES',
        ]);
    }
}

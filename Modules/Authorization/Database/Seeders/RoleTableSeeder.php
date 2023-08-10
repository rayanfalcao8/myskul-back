<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\Entities\Role;
use Modules\Core\Traits\DisableForeignKeys;

class RoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        Role::create([
            'name' => 'admin',
            'display_name' => 'Super Administrateur',
            'description' => __('Administrateur de la plateforme avec accès au panneau d\'administration aux configurations et aux outils de développement.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'customer',
            'display_name' => 'Client',
            'description' => __('Donne accès aux clients à toutes les fonctionnalités pour l\'utilisation de la plateforme.'),
            'can_be_removed' => false,
        ]);

        $this->enableForeignKeys();
    }
}

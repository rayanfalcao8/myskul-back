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
            'name' => 'super_admin',
            'display_name' => 'Super Administrateur',
            'description' => __('Administrateur de la plateforme avec accès au panneau d\'administration aux configurations et aux outils de développement.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => __('Top management de la plateforme.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'super_account_manager',
            'display_name' => 'Responsable gestionnaire de compte',
            'description' => __('Responsable et administrateur des gestionnaires de comptes clients.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'account_manager',
            'display_name' => 'Gestionnaire de compte',
            'description' => __('Gestionnaire des comptes clients.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'super_customer_service',
            'display_name' => 'Responsable Service client',
            'description' => __('Manage et administre les fonctionnalités pour le service client.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'customer_service',
            'display_name' => 'Service client',
            'description' => __('S\'occupe des actions et de la gestion des clients.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'customer',
            'display_name' => 'Client',
            'description' => __('Donne accès aux clients à toutes les fonctionnalités pour l\'utilisation de la plateforme.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'super_risk_service',
            'display_name' => 'Responsable Service risque',
            'description' => __('Manage et administre les fonctionnalités pour le service risque.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'risk_service',
            'display_name' => 'Service risque',
            'description' => __('Contrôle et supervise les failles au sein de l\'application.'),
            'can_be_removed' => false,
        ]);

        Role::create([
            'name' => 'developer',
            'display_name' => 'Développeur',
            'description' => __('S\'occupe de fixer et corriger les bug et maintenance de la plateforme.'),
            'can_be_removed' => false,
        ]);

        $this->enableForeignKeys();
    }
}

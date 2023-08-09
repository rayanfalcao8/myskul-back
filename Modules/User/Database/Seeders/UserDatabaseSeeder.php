<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = config('auth.providers.users.model');

        $user = tap((new $model)->forceFill([
            'email' => 'admin@admin.com',
            'name' => 'Admin Manager',
            'password' => Hash::make('password'),
            'email_verified_at' => now()->toDateTimeString(),
            'last_login_at' => now()->toDateTimeString(),
            'last_login_ip' => request()->getClientIp(),
        ]))->save();

        $user->assignRole('admin');
    }
}

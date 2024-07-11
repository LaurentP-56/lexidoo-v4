<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user           = new User();
        $user->nom      = 'Admin';
        $user->prenom   = 'Admin';
        $user->email    = 'admin@admin.com';
        $user->password = bcrypt('admin12345');
        $user->isAdmin  = "1";
        $user->save();
    }
}

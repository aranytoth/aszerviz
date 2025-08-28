<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleManager = Role::create(['name' => 'manager']);
        $roleMechanic = Role::create(['name' => 'mechanic']);

        // Alapértelmezett felhasználók

        $user1 = User::create([
            'name' => 'Arany-Tóth Tibor',
            'email' => 'aranytoth.tibor@gmail.com',
            'password' => Hash::make('19:Atika77'),
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 10
        ]);

        $user1->assignRole('admin');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};

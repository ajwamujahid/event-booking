<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo admin user
        $admin = User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // 4 extra users
        $users = User::factory(4)->create();

        // 15 events by admin
        Event::factory(15)->create(['created_by' => $admin->id]);

        // 1-3 events per user
        $users->each(function ($user) {
            Event::factory(rand(1, 3))->create(['created_by' => $user->id]);
        });

        $this->command->info('✅  Seeding complete!');
        $this->command->info('👤  Login: admin@example.com / password');
    }
}
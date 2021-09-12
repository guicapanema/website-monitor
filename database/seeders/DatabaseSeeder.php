<?php

namespace Database\Seeders;

use App\Models\Snapshot;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Test user',
            'email' => 'test@user.com',
            'password' => Hash::make('test'), // password
        ]);

        Snapshot::withoutEvents(function () {
            Website::factory(5)
                ->has(Snapshot::factory()->count(3))
                ->create();
        });
    }
}

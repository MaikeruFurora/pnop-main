<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create();
        \App\Models\Teacher::factory()->count(10)->create();
        // $this->call(StrandSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(SchoolYearSeeder::class);
        $this->call(SchoolProfileSeeder::class);
    }
}

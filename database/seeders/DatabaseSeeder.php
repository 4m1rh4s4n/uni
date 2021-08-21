<?php

namespace Database\Seeders;

use App\Models\Awards;
use App\Models\Publication;
use App\Models\Thesis;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
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
        $pubs = Publication::factory()->count(10)->english()->make();
        $user = User::factory()->has($pubs, 'publications')
            // ->has(Publication::factory()->count(10)->make())
            // ->has(Awards::factory()->count(10)->english()->make())
            // ->has(Awards::factory()->count(10)->make())
            // ->has(Thesis::factory()->count(10)->english()->make())
            // ->has(Thesis::factory()->count(10)->make())
            ->count(5)
            ->create();
    }
}

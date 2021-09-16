<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'name' => Str::random(10),
        ]);
        Tag::create([
            'name' => Str::random(10),
        ]);
        Tag::create([
            'name' => Str::random(10),
        ]);
    }
}

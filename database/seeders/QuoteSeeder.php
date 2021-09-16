<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Quote;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quote::create([
            'quote' => Str::random(300),
            'author' => Str::random(20),
        ]);
        Quote::create([
            'quote' => Str::random(300),
            'author' => Str::random(20),
        ]);
        Quote::create([
            'quote' => Str::random(300),
            'author' => Str::random(20),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Quote;

class QuoteTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        Quote::all()->each(function ($quote) use ($tags) {
            $quote->tags()->attach(
                $tags->random(rand(1,2))->pluck('id')->toArray()
            );
        });
    }
}

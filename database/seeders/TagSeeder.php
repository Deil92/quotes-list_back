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
            'name' => "Фильмы",
        ]);
        Tag::create([
            'name' => "Природа",
        ]);
        Tag::create([
            'name' => "Бизнес",
        ]);
        Tag::create([
            'name' => "Сериалы",
        ]);
        Tag::create([
            'name' => "Любовь",
        ]);
        Tag::create([
            'name' => "Книга",
        ]);
        Tag::create([
            'name' => "Приключения",
        ]);
        Tag::create([
            'name' => "Будущее",
        ]);
        Tag::create([
            'name' => "Деньги",
        ]);
    }
}

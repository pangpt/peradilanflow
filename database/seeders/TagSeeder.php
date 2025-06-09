<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = Question::all();

        $tags = Tag::factory(5)
            // ->hasAttached($questions)
            ->create();

        $questions->each(function(Question $question) use($tags) {
            $question->tags()->toggle(
                $tags->random(3)->pluck('id')->all()
            );
        });
    }
}

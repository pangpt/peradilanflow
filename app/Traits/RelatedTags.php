<?php

namespace App\Traits;

trait RelatedTags
{
    protected function relatedTags(array $questions, array $excludes = [])
    {
        return collect($questions)
            ->map(fn ($question) => $question->tags->pluck('name'))
            ->flatten()
            ->unique()
            ->filter(fn ($tag) => !in_array($tag, $excludes))
            ->values();
    }
}
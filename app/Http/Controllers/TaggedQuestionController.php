<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Traits\RelatedTags;

class TaggedQuestionController extends Controller
{
    use RelatedTags;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Tag $tag)
    {
        $questions = QuestionResource::collection(
            $tag->questions()
                ->with('user')
                ->withCount('answers')
                ->latest()
                ->paginate(15)
                ->withQueryString()
        );

        $tags = $this->relatedTags($questions->items(), [$tag->name]);
    
        return inertia('Questions/Index', [
            'questions' => $questions,
            'tags' => $tags,
            'tag' => $tag,
        ]);
    }
}

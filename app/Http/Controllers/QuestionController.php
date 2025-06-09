<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\RelatedQuestionResource;
use App\Models\Tag;
use App\Traits\RelatedTags;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    use RelatedTags;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // sleep(3); # simulate long request to show progress indicator
        $filter = $request->query('filter', 'latest');
        $questions = QuestionResource::collection(
            Question::with('user')
                ->withCount('answers')
                ->when($filter === 'mine', function ($query) {
                    $query->mine();
                })
                ->when($filter === 'unanswered', function ($query) {
                    $query->has('answers', '=', 0);
                })
                ->when($filter === 'scored', function ($query) {
                    $query->whereNotNull('best_answer_id');
                })
                ->latest()
                ->paginate(15)
                ->withQueryString()
        );

        $tags = $this->relatedTags($questions->items());
        $tagOptions = Tag::pluck('name')->all();

        return inertia('Questions/Index', [
            'questions' => $questions,
            'filter' => $filter,
            'tags' => $tags,
            'tag_options' => $tagOptions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = $request->user()->questions()->create(
            $request->only(['title', 'body'])
        );
        $question->tagged($request->tags);

        return back()->with('success', "Your question submitted successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return inertia('Questions/Show', [
            'question' => QuestionResource::make($question),
            'answers' => AnswerResource::collection(
                $question->answers()->latest()->paginate(5)
            ),
            'tags' => Tag::take(20)->pluck('name'),
            'related_questions' => RelatedQuestionResource::collection(
                Question::with('tags')->whereNot('id', $question->id)
                    ->whereHas('tags', function ($query) use ($question) {
                        $query->whereIn('name', $question->tags->pluck('name'));
                    })
                    ->take(10)
                    ->get()
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        Gate::authorize('update', $question);

        $question->update($request->only(['title', 'body']));
        $question->tagged($request->tags);

        return back()->with('success', 'Your question updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        Gate::authorize('delete', $question);

        $question->delete();

        return back()->with('success', 'Your question deleted successfully.');
    }
}

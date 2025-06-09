<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withCount('questions')->orderBy('name')->paginate(15);

        return inertia('Tags/Index', [
            'tags' => TagResource::collection($tags),
            'can' => [
                'create_tag' => request()->user() && request()->user()->can('create', Tag::class)
            ]
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
    public function store(StoreTagRequest $request)
    {
        Gate::authorize('create', Tag::class);
        
        Tag::create($request->validated());

        return back()->with('success', 'New tag has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        Gate::authorize('update', Tag::class);

        $tag->update($request->validated());

        return back()->with('success', 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('delete', $tag);

        $tag->questions()->detach();
        $tag->delete();

        return back()->with('success', 'Tag deleted successfully.');
    }
}

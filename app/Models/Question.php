<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function booted(): void
    {
        static::creating(function (Question $question) {
            $question->slug = str($question->title)->slug();
        });  
    }

    public function scopeMine(Builder $query)
    {
        if (!auth()->user()) {
            return;
        }

        $query->whereBelongsTo(auth()->user());
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tagged(array $tags)
    {
        $tags = Tag::whereIn('name', $tags)->pluck('id')->all();

        $this->tags()->sync($tags);
    }

    public function bookmarkedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function acceptAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}

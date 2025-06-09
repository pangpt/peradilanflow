<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use App\Models\Answer;

class AnswerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id || in_array($user->role, [Role::ADMIN, Role::EDITOR]);
    }
    
    public function delete(User $user, Answer $answer): bool
    {
        return $user->id === $answer->user_id || $user->role === Role::ADMIN;
    }
    
    public function accept(User $user, Answer $answer): bool
    {
        return $user->id === $answer->question->user_id;
    }
}

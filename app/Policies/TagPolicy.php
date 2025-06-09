<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::EDITOR]);
    }
    
    public function update(User $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::EDITOR]);
    }
    
    public function delete(User $user, Tag $tag): bool
    {
        return $user->role === Role::ADMIN || 
            ($user->role === Role::EDITOR && $tag->questions->count() < 1);
    }
}

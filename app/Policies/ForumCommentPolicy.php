<?php

namespace App\Policies;

use App\ForumComment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ForumCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ForumComment  $forumComment
     * @return mixed
     */
    public function view(User $user, ForumComment $forumComment)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return auth()->check() ?? redirect()->route('login');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ForumComment  $forumComment
     * @return mixed
     */
    public function update(User $user, ForumComment $forumComment)
    {
        return $user->id === $forumComment->user_id && $forumComment->forum->is_solved === false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ForumComment  $forumComment
     * @return mixed
     */
    public function delete(User $user, ForumComment $forumComment)
    {
        return $user->id === $forumComment->user_id && $forumComment->forum->is_solved === false || $user->role === 1;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ForumComment  $forumComment
     * @return mixed
     */
    public function restore(User $user, ForumComment $forumComment)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ForumComment  $forumComment
     * @return mixed
     */
    public function forceDelete(User $user, ForumComment $forumComment)
    {
        return false;
    }
}

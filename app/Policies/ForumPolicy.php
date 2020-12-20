<?php

namespace App\Policies;

use App\Forum;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class ForumPolicy
{
    use HandlesAuthorization;

    private const ADMIN = 1;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny()
    {
        return true;
        // return ($request->has('filter') && $request->get('filter') === 'my' && !auth()->check()) ? redirect()->route('login') : Response::allow();
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
     * @param  \App\Forum  $forum
     * @return mixed
     */
    public function update(User $user, Forum $forum)
    {
        return $user->id === $forum->user_id && is_null($forum->solved_at);
    }

    public function solved(User $user, Forum $forum)
    {
        return $user->id === $forum->user_id || $user->role === static::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Forum  $forum
     * @return mixed
     */
    public function delete(User $user, Forum $forum)
    {
        return $user->id === $forum->user_id || $user->role === static::ADMIN;
    }
}

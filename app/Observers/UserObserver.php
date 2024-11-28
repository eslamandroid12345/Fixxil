<?php

namespace App\Observers;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use App\Repository\UserTimeRepositoryInterface;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */

    public function __construct(
        private readonly UserTimeRepositoryInterface $usertimeRepository,
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }
    public function created(User $user): void
    {

    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

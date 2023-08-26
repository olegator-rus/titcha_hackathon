<?php

namespace App\Observers;

use App\Models\User;
use App\Services\AccreditationService;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Логика выполняющаяся при создании нового пользователя.
    }
}

<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Application $application)
    {
        return $user->isAdmin() || $application->user_id === $user->id;
    }

    public function update(User $user, Application $application)
    {
        return $application->user_id === $user->id && $application->isEditable();
    }

    public function submit(User $user, Application $application)
    {
        return $application->user_id === $user->id && in_array($application->status, ['Draft', 'Needs correction'], true);
    }

    public function manage(User $user)
    {
        return $user->isAdmin();
    }
}

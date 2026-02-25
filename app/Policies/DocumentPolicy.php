<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Document $document)
    {
        return $user->isAdmin() || $document->application->user_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->isApplicant();
    }
}

<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Organization $organization): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Organization $organization): bool
    {
        return $user->isAdmin() || $organization->user_id === $user->id;
    }

    public function delete(User $user, Organization $organization): bool
    {
        return $user->isAdmin() || $organization->user_id === $user->id;
    }
}
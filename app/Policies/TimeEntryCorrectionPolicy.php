<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TimeEntryCorrection;
use App\Models\User;

class TimeEntryCorrectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return true;
        return $user->checkPermissionTo('view-any TimeEntryCorrection');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TimeEntryCorrection $timeentrycorrection): bool
    {

        return true;
        return $user->checkPermissionTo('view TimeEntryCorrection');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return true;
        return $user->checkPermissionTo('create TimeEntryCorrection');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TimeEntryCorrection $timeentrycorrection): bool
    {

        return true;
        return $user->checkPermissionTo('update TimeEntryCorrection');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TimeEntryCorrection $timeentrycorrection): bool
    {

        return true;
        return $user->checkPermissionTo('delete TimeEntryCorrection');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TimeEntryCorrection $timeentrycorrection): bool
    {

        return true;
        return $user->checkPermissionTo('restore TimeEntryCorrection');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TimeEntryCorrection $timeentrycorrection): bool
    {

        return true;
        return $user->checkPermissionTo('force-delete TimeEntryCorrection');
    }
}

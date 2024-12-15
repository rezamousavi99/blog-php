<?php

namespace App\Policies;

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


    public function create(User $user){
        if($user->is_admin === 1){
            return true;
        }
        return false;
    }
}

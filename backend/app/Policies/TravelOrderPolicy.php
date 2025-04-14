<?php

namespace App\Policies;

use App\Models\TravelOrder;
use App\Models\User;

class TravelOrderPolicy
{

    public function updateStatus(User $user, TravelOrder $travelOrder): bool
    {
        return $user->id !== $travelOrder->user_id;
    }
}

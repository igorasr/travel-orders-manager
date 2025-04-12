<?php

namespace App\Observers;

use App\Enums\TravelOrderStatus;
use App\Models\TravelOrder;
use App\Notifications\TravelOrderStatusNotification;

class TravelOrderObserver
{
    /**
     * Handle the TravelOrder "created" event.
     */
    public function created(TravelOrder $travelOrder): void
    {
        //
    }

    /**
     * Handle the TravelOrder "updated" event.
     */
    public function updated(TravelOrder $travelOrder)
    {
        if ($travelOrder->isDirty('status')) {
            $status = $travelOrder->status;

            if (in_array($status, [
                TravelOrderStatus::APROVADO->value,
                TravelOrderStatus::CANCELADO->value
            ])) {
                $travelOrder->user?->notify(new TravelOrderStatusNotification($travelOrder));
            }
        }
    }
    /**
     * Handle the TravelOrder "deleted" event.
     */
    public function deleted(TravelOrder $travelOrder): void
    {
        //
    }

    /**
     * Handle the TravelOrder "restored" event.
     */
    public function restored(TravelOrder $travelOrder): void
    {
        //
    }

    /**
     * Handle the TravelOrder "force deleted" event.
     */
    public function forceDeleted(TravelOrder $travelOrder): void
    {
        //
    }
}

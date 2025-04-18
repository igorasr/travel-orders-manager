<?php

namespace App\Casts;

use App\ValueObjects\TravelDestination;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TravelDestinationCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return TravelDestination::fromArray(json_decode($value, true));
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $travelDestination, array $attributes): mixed
    {
        if (is_array($travelDestination)) {
            $travelDestination = TravelDestination::fromArray($travelDestination);
        }

        return [$key => json_encode($travelDestination->toArray())];
    }
}

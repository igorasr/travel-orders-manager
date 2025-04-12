<?php

namespace App\Services;

use App\DTOs\FilterTravelOrderDTO;

class TravelOrderFilter
{
    public static function apply($query, FilterTravelOrderDTO $filters)
    {
        return $query
            ->where('user_id', auth()->user()->id)
            ->when($filters->status, fn($q, $v) => $q->where('status', $v))
            ->when($filters->destino, fn($q, $v) => $q->where('destino', json_encode($v)))
            ->when($filters->cidade, fn($q, $v) => $q->where('destino->city', $v))
            ->when($filters->estado, fn($q, $v) => $q->where('destino->state', $v))
            ->when($filters->pais, fn($q, $v) => $q->where('destino->country', $v))
            ->when($filters->data_ida, fn($q, $v) => $q->whereDate('data_ida', '>=', $v))
            ->when($filters->data_volta, fn($q, $v) => $q->whereDate('data_volta', '<=', $v));
    }
}
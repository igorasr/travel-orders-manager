<?php

namespace App\Models;

use App\Casts\TravelDestinationCast;
use App\Enums\TravelOrderStatus;
use App\Exceptions\InvalidStatusTransitionException;
use App\Exceptions\InvalidTravelOrderCancellation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class TravelOrder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'destino',
        'data_ida',
        'data_volta',
        'status'
    ];

    protected $casts = [
        'status' => TravelOrderStatus::class,
        'destino' => TravelDestinationCast::class,
        'data_ida' => 'date',
        'data_volta' => 'date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function setStatus(string $status): self
    {
        return $this->changeStatus($status);
    }


    private function changeStatus(string $status): self
    {
        $newStatus = TravelOrderStatus::tryFrom($status);
        if (!$newStatus) {
            throw ValidationException::withMessages([
                'status' => "Status '{$status}' inválido.",
            ]);
        }
        
        $current = $this->status;
        if (!$current->canTransitionTo($newStatus)) {
            throw new InvalidStatusTransitionException($current->value, $newStatus->value);
        }
        
        if ($newStatus === TravelOrderStatus::CANCELADO && !$this->canCancel()) {
            throw new InvalidTravelOrderCancellation("Um pedido de viagem só pode ser cancelado com mais de 30 dias de antecedência.");
        }

        $this->status = $newStatus;

        return $this;   
    }


    // Pedidos podem ser cancelados com mais de 30 dias de antecedência
    private function canCancel()
    {
        return Carbon::now()->diffInDays($this->data_ida, false) > 30;
    }
}

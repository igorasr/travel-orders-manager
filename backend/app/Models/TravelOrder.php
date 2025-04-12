<?php

namespace App\Models;

use App\Casts\TravelDestinationCast;
use App\Enums\TravelOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

<?php

namespace App\Repositories;

use App\Models\TravelOrder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TravelOrderRepository
{
  public function __construct(protected TravelOrder $travelOrder) {}

  public function getTravelOrders()
  {
    return $this->travelOrder->get();
  }

  public function getTravelOrderById($id)
  {
    return $this->travelOrder->with(['user'])->findOr($id, function () {
      throw new ModelNotFoundException("Pedido de viagem não encontrado.", 404);
    });
  
  }

  public function createTravelOrder($data)
  {
    return $this->travelOrder->create($data);
  }

  public function deleteTravelOrder($id)
  {
    $travelOrder = $this->getTravelOrderById($id);
    $travelOrder->delete();
    return $travelOrder;
  }
  
  public function getTravelOrdersByUserId($userId)
  {
    return $this->travelOrder->where('user_id', $userId)->with(['user', 'travelOrderDetails'])->get();
  }
}

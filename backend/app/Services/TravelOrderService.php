<?php

namespace App\Services;

use App\DTOs\FilterTravelOrderDTO;
use App\DTOs\TravelOrderDTO;
use App\Models\TravelOrder;
use App\Repositories\TravelOrderRepository;
use App\Services\TravelOrderFilter;

class TravelOrderService
{
    public function __construct(
        protected TravelOrder $travelOrder, 
        protected TravelOrderRepository $repository
    ){}

    public function getAllOrders(FilterTravelOrderDTO $filters)
    {
        return TravelOrderFilter::apply(TravelOrder::query(), $filters)->with(['user'])->get();
    }

    public function createTravelOrder(TravelOrderDTO $data)
    {
        $travelOrder = $this->repository->createTravelOrder($data->toArray());

        return $travelOrder;
    }

    public function updateTravelOrderStatus(int $id, string $status)
    {
        $travelOrder = $this->repository->getTravelOrderById($id);
       
        if($travelOrder->user_id == auth()->user()->id){
            throw new \Exception('Você não pode definir o status ao criar um pedido como solicitante.');
        }

        $travelOrder->setStatus($status);
        $travelOrder->save();

        return $travelOrder;
    }

    public function getTravelOrderById(int $id)
    {
        $travelOrder = $this->repository->getTravelOrderById($id);

        return $travelOrder;
    }

    public function deleteTravelOrder(int $id)
    {
        return $this->repository->deleteTravelOrder($id);
    }
}
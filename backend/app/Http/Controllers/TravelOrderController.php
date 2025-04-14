<?php

namespace App\Http\Controllers;

use App\DTOs\FilterTravelOrderDTO;
use App\DTOs\TravelOrderDTO;
use App\Enums\TravelOrderStatus;
use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Requests\UpdateStatusTravelOrderRequest;
use App\Http\Resources\TravelOrderResource;
use App\Models\TravelOrder;
use App\Services\TravelOrderService;
use Illuminate\Http\Request;

class TravelOrderController extends Controller
{
    public function __construct(protected TravelOrderService $travelOrderService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = FilterTravelOrderDTO::fromArray($request->query());
        return TravelOrderResource::collection(
            $this->travelOrderService->getAllOrders($filters)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelOrderRequest $request)
    {
        $data = TravelOrderDTO::fromArray($request->validated());

        $travelOrder = $this->travelOrderService->createTravelOrder($data);

        return new TravelOrderResource($travelOrder)->response()
            ->setStatusCode(201);
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(UpdateStatusTravelOrderRequest $request, TravelOrder $travelOrder)
    {
        $travelOrder = $this->travelOrderService->updateTravelOrderStatus($travelOrder->id, $request->input('status'));
        return new TravelOrderResource($travelOrder)->response()
            ->setStatusCode(200);
    }

    /**
     * Cancel the specified resource.
     */
    public function cancelTravelOrder(TravelOrder $travelOrder)
    {
        $travelOrder = $this->travelOrderService->updateTravelOrderStatus($travelOrder->id, TravelOrderStatus::CANCELADO->value);
        return new TravelOrderResource($travelOrder)->response()
            ->setStatusCode(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelOrder $travelOrder)
    {
        $travelOrder = $this->travelOrderService->getTravelOrderById($travelOrder->id);
        return new TravelOrderResource($travelOrder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

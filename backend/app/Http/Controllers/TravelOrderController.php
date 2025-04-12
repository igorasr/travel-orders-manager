<?php

namespace App\Http\Controllers;

use App\DTOs\FilterTravelOrderDTO;
use App\DTOs\TravelOrderDTO;
use App\Enums\TravelOrderStatus;
use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Requests\UpdateStatusTravelOrderRequest;
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
        return $this->travelOrderService->getAllOrders($filters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTravelOrderRequest $request)
    {       
        $data = TravelOrderDTO::fromArray($request->validated());

        $travelOrder = $this->travelOrderService->createTravelOrder($data);

        return response()->json($travelOrder, 201);
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(UpdateStatusTravelOrderRequest $request, string $id)
    {
        $travelOrder = $this->travelOrderService->updateTravelOrderStatus($id, $request->input('status'));
        return response()->json($travelOrder, 200);
    }

    /**
     * Cancel the specified resource.
     */
    public function cancelTravelOrder(string $id)
    {
        $travelOrder = $this->travelOrderService->updateTravelOrderStatus($id, TravelOrderStatus::CANCELADO->value);
        return response()->json($travelOrder, 200);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $travelOrder = $this->travelOrderService->getTravelOrderById($id);
        return $travelOrder;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

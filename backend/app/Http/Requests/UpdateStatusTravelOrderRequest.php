<?php

namespace App\Http\Requests;

use App\Enums\TravelOrderStatus;
use App\Models\TravelOrder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusTravelOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $travelOrder = TravelOrder::find($this->route('TravelOrder'));

        return $travelOrder->user_id !== $this->user()->id;
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('Você não pode definir o status ao criar um pedido como solicitante.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(TravelOrderStatus::class)]
        ];
    }
}

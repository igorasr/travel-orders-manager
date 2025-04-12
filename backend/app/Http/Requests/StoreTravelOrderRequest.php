<?php

namespace App\Http\Requests;

use App\Enums\TravelOrderStatus;
use App\Rules\AllowedArrayKeys;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTravelOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'destino' => ['required', 'array', new AllowedArrayKeys(['city', 'state', 'country'])],
            'status' => ['required', Rule::enum(TravelOrderStatus::class)],
            'data_ida' => 'required|date|after:today',
            'data_volta' => 'required|date|after:data_ida',
            'user_id' => 'required|exists:users,id',
        ];
    }
}

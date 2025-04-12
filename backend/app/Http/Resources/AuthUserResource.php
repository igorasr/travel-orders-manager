<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthUserResource extends JsonResource
{
    private $token;
    private $user;

    public function __construct($token, $user)
    {
        parent::__construct(null);
        $this->token = $token;
        $this->user = $user;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $payload = JWTAuth::setToken($this->token)->getPayload();
        $expiresAt = Carbon::createFromTimestamp($payload->get('exp'))->toIso8601String();
        $expiresIn = $payload->get('exp') - now()->timestamp;

        return [
            'token'=> $this->token,
            'token_type'=> 'Bearer',
            'expires_in'=> $expiresIn,
            'expires_at'=> $expiresAt,
        ];
    }
}

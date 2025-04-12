<?php

namespace App\DTOs;

use App\Contracts\DTOInterface;
use App\Enums\TravelOrderStatus;

class FilterTravelOrderDTO implements DTOInterface
{
    public function __construct(
        public readonly ?string $userId = null,
        public readonly ?TravelOrderStatus $status = null,
        public readonly ?string $destino = null,
        public readonly ?string $cidade = null,
        public readonly ?string $pais = null,
        public readonly ?string $estado = null,
        public readonly ?string $data_ida = null,
        public readonly ?string $data_volta = null,
    ) {}

    public function validade(): void
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'] ?? null,
            status: isset($data['status']) ? TravelOrderStatus::tryFrom($data['status']) : null,
            destino: $data['destino'] ?? null,
            cidade: $data['cidade'] ?? null,
            pais: $data['pais'] ?? null,
            estado: $data['estado'] ?? null,
            data_ida: $data['data_ida'] ?? null,
            data_volta: $data['data_volta'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'status' => $this->status?->value,
            'destino' => $this->destino,
            'cidade' => $this->cidade,
            'pais' => $this->pais,
            'estado' => $this->estado,
            'data_ida' => $this->data_ida,
            'data_volta' => $this->data_volta,
        ];
    }
}
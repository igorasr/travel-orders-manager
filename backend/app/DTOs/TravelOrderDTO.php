<?php

namespace App\DTOs;

use App\Contracts\DTOInterface;
use App\Enums\TravelOrderStatus;
use App\ValueObjects\TravelDestination;

class TravelOrderDTO implements DTOInterface
{
    public function __construct(
        public readonly string $userId,
        public readonly TravelOrderStatus $status,
        public readonly TravelDestination $destino,
        public readonly string $data_ida,
        public readonly string $data_volta,
    ) {
        $this->validade();
    }

    public function validade(): void
    {
        $this->validadeEmptyProps();
    }
    
    private function validadeEmptyProps()
    {
        if (empty($this->userId)) {
            throw new \InvalidArgumentException('User ID is required.');
        }

        if (empty($this->status)) {
            throw new \InvalidArgumentException('Status is required.');
        }

        if (empty($this->destino)) {
            throw new \InvalidArgumentException('Destination is required.');
        }

        if (empty($this->data_ida)) {
            throw new \InvalidArgumentException('Departure date is required.');
        }

        if (empty($this->data_volta)) {
            throw new \InvalidArgumentException('Return date is required.');
        }
        if ($this->data_ida > $this->data_volta) {
            throw new \InvalidArgumentException('Departure date must be before return date.');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'] ?? null,
            status: isset($data['status']) ? TravelOrderStatus::tryFrom($data['status']) : null,
            destino: isset($data['destino']) ? TravelDestination::fromArray($data['destino']) : null,
            data_ida: $data['data_ida'] ?? null,
            data_volta: $data['data_volta'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'status' => $this->status->value,
            'destino' => $this->destino->toArray(),
            'data_ida' => $this->data_ida,
            'data_volta' => $this->data_volta,
        ];
    }
}
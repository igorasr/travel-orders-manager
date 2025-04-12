<?php

namespace App\ValueObjects;

class TravelDestination
{
  public function __construct(
    public readonly string $city,
    public readonly string $state,
    public readonly string $country
  ) {
    $this->validate();
  }

  private function validate(): void
  {
    if (empty($this->city) || empty($this->state) || empty($this->country)) {
      throw new \InvalidArgumentException('City, state, and country cannot be empty.');
    }
  }

  public static function fromArray(mixed $data): self
  {
    return new self(
      $data['city'] ?? '',
      $data['state'] ?? '',
      $data['country'] ?? '',
    );
  }

  public function toArray(): array
  {
    return [
      'city' => $this->city,
      'state' => $this->state,
      'country'   => $this->country,
    ];
  }

  public function __toString(): string
  {
    return "{$this->city}, {$this->state} - {$this->country}";
  }
}

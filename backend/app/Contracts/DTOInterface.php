<?php

namespace App\Contracts;

interface DTOInterface
{
    public function validade(): void;
    public static function fromArray(array $data): self;
    public function toArray(): array;
}
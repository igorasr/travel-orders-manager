<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidTravelOrderCancellation extends BaseExeption
{
    public function __construct(string $message = "Pedido de viagem não pode ser cancelado.")
    {
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

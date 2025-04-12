<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class InvalidStatusTransitionException extends BaseExeption
{
    public function __construct(string $fromStatus, string $toStatus)
    {
        $message = "Transição de status '{$fromStatus}' para '{$toStatus}' não é permitida.";
        parent::__construct($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

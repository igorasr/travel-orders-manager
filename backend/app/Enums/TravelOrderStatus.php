<?php

namespace App\Enums;

enum TravelOrderStatus: string
{
    case SOLICITADO = 'solicitado';
    case APROVADO   = 'aprovado';
    case CANCELADO  = 'cancelado';

    public function canTransitionTo(TravelOrderStatus $to): bool
    {
        return match ($this) {
            self::SOLICITADO => in_array($to, [self::APROVADO, self::CANCELADO]),
            self::APROVADO   => $to === self::CANCELADO,
            self::CANCELADO  => false, // Pedido cancelado não pode voltar
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

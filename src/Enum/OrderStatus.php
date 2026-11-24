<?php

namespace App\Enum;

enum OrderStatus: string
{
    case ACTIVE = 'active';
    case ENDED = 'ended';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'En cours',
            self::ENDED => 'Terminée',
            self::CANCELLED => 'Annulée',
        };
    }
}

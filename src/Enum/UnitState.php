<?php

namespace App\Enum;

enum UnitState: string
{
    case AVAILABLE = 'available';
    case MAINTENANCE = 'maintenance';
    case OUT_OF_ORDER = 'out_of_order';

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'En service',
            self::MAINTENANCE => 'En maintenance',
            self::OUT_OF_ORDER => 'Hors service',
        };
    }
}

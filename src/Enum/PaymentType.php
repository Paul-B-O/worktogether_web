<?php

namespace App\Enum;

enum PaymentType: string
{
    case MONTHLY = 'monthly';
    case ANNUAL = 'annual';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Mensuel',
            self::ANNUAL => 'Annuel',
        };
    }

    /**
     * Durée d'une période de contrat, en mois.
     */
    public function months(): int
    {
        return match ($this) {
            self::MONTHLY => 1,
            self::ANNUAL => 12,
        };
    }
}

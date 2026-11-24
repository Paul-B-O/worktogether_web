<?php

namespace App\Enum;

enum PaymentMethod: string
{
    case CARD = 'card';
    case TRANSFER = 'transfer';
    case SEPA = 'sepa';

    public function label(): string
    {
        return match ($this) {
            self::CARD => 'Carte bancaire',
            self::TRANSFER => 'Virement',
            self::SEPA => 'Prélèvement SEPA',
        };
    }
}

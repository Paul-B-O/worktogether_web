<?php

namespace App\Enum;

enum UnitType: string
{
    case WEB = 'web';
    case STORAGE = 'storage';
    case COMPUTE = 'compute';
    case DATABASE = 'database';
    case BACKUP = 'backup';

    public function label(): string {
        return match ($this) {
            self::WEB => 'Site web',
            self::STORAGE => 'Stockage',
            self::COMPUTE => 'Calcul',
            self::DATABASE => 'Base de données',
            self::BACKUP => 'Sauvegarde',
        };
    }
}
<?php

namespace App\Enum;

enum UnitType: string
{
    case WEB = 'web';
    case STORAGE = 'storage';
    case COMPUTE = 'compute';
    case DATABASE = 'database';
    case BACKUP = 'backup';
}

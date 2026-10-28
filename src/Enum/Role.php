<?php

namespace App\Enum;

enum Role: string
{
    case ADMINISTRATOR = 'ROLE_ADMINISTRATOR';
    case ACCOUNTANT = 'ROLE_ACCOUNTANT';
    case TECHNICIAN = 'ROLE_TECHNICIAN';
    case SALES = 'ROLE_SALES';
    case CUSTOMER = 'ROLE_CUSTOMER';
}

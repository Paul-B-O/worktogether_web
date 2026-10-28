<?php

namespace App\Enum;

enum Role: string {
    case ADMINISTRATEUR = "role_administrator";
    case ACCOUNTANT = "role_accountant";
    case TECHNICIEN = "role_technician";
}
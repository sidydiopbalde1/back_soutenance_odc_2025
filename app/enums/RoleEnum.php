<?php

namespace App\enums;

enum RoleEnum: string
{
    case MANAGER = 'manager';
    case ADMIN = 'admin';
    case MARKETEUR = 'marketeur';
    case SUPERVISEUR = 'superviseur';
}

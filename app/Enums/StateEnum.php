<?php
namespace App\Enums;

enum StateEnum: string
{
    case SUCCESS = 'success';
    case VALIDATION_ERROR = 'validation_error';
    case UNAUTHORIZED = 'unauthorized';
    case NOT_FOUND = 'not_found';
    case ERROR = 'error';
}

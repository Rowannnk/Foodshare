<?php

namespace App\Enums;

enum UserRole : string
{
    case ADMIN = 'admin';
    case DONOR = 'donor';
    case RECIPIENT = 'recipient';
}

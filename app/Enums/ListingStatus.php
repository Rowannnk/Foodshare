<?php

namespace App\Enums;

enum ListingStatus: string
{
    case AVAILABLE = 'available';
    case RESERVED = 'reserved';
    case COLLECTED = 'collected';
    case EXPIRED = 'expired';
}
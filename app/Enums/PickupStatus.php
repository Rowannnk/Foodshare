<?php

namespace App\Enums;

enum PickupStatus: string
{
    case PENDING = 'pending';
    case COLLECTED = 'collected';
    case MISSED = 'missed';
}

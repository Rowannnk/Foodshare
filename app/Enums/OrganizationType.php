<?php

namespace App\Enums;

enum OrganizationType: string
{
    case RESTAURANT = 'restaurant';
    case CAFE = 'cafe';
    case BAKERY = 'bakery';
    case SUPERMARKET = 'supermarket';
    case CHARITY = 'charity';
}
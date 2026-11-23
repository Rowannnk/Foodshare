<?php

namespace App\Enums;

enum OrganizationType: string
{
    case RESTAURANT = 'restaurant';
    case CAFE = 'cafe';
    case BAKERY = 'bakery';
    case SUPERMARKET = 'supermarket';
    case CHARITY = 'charity';

    public static function forRole(UserRole $role): array
    {
        return match ($role) {
            UserRole::ADMIN => self::cases(),
            UserRole::DONOR => [self::RESTAURANT, self::CAFE, self::BAKERY, self::SUPERMARKET],
            UserRole::RECIPIENT => [self::CHARITY],
        };
    }
}

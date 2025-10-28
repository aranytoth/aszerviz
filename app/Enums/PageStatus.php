<?php

namespace App\Enums;

enum PageStatus: int
{
    case Draft = 1;
    case Visible = 2;
    case Hidden = 3;
    case Archive = 4;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'draft',
            self::Visible => 'visible',
            self::Hidden => 'hidden',
            self::Archive => 'archive',
        };
    }
}
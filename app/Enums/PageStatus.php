<?php

namespace App\Enums;

enum PageStatus: int
{
    case Draft = 1;
    case Visible = 10;
    case Hidden = 3;
    case Archive = 4;

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Piszkozat',
            self::Visible => 'Publikus',
            self::Hidden => 'Rejtett',
            self::Archive => 'Archivált',
        };
    }
}
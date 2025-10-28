<?php

namespace App\Enums;

enum PageType: int
{
    case Page = 1;
    case Post = 2;

    public function label(): string
    {
        return match ($this) {
            self::Page => 'page',
            self::Post => 'post',
        };
    }
}
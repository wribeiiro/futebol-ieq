<?php

namespace App\Http\Game\Enums;

enum StatusGameEnum
{
    case FINISHED;
    case SELECT_PLAYERS;
    case SELECT_TEAMS;

    public function getFlag(): int
    {
        return match ($this) {
            self::FINISHED => 1,
            self::SELECT_PLAYERS => 2,
            self::SELECT_TEAMS => 3,
        };
    }
}

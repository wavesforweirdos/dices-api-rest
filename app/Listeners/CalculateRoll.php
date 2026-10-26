<?php

namespace App\Listeners;

use App\Events\PlayerThrowsDices;

class CalculateRoll
{
    /**
     * Gana (1) quien saca 7 con los dos dados; en cualquier otro caso pierde (0).
     */
    public function handle(PlayerThrowsDices $event): int
    {
        return ($event->dice1 + $event->dice2) === 7 ? 1 : 0;
    }
}

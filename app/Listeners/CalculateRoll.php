<?php

namespace App\Listeners;

use App\Events\PlayerThrowsDices;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateRoll
{
    public function __construct()
    {
        //
    }

    public function handle(PlayerThrowsDices $event)
    {
        $total = $this->dice1 + $this->dice2;

        switch ($total) {
            case 7:
                $this->result = 1;
                break;
            default:
                $this->result = 0;
                break;
        }

        return [
            'dice1' => $this->dice1,
            'dice2' => $this->dice2,
            'result' => $this->result,
            'user_id' => $this->id
        ];
    }
}

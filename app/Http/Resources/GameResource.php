<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //Resultado de la partida
        if (!$this->result) {
            $textResult = 'You lost!';
        } else {
            $textResult = 'You win!';
        };

        $total = $this->dice1 + $this->dice2;

        return [
            'game' => [
                'dice1' => $this->dice1,
                'dice2' => $this->dice2,
                'message' => $textResult . ' The sum of your throw is ' . $total . '.',
            ]
        ];
    }
}

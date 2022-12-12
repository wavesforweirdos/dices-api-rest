<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $dice1 = fake()->numberBetween(1, 7);
        $dice2 = fake()->numberBetween(1, 7);
        $total = $dice1 + $dice2;
        switch ($total) {
            case 7:
                $result = 1;
                break;

            default:
                $result = 0;
                break;
        }
        return [
            'dice1' => $dice1,
            'dice2' => $dice2,
            'result' => $result,
            'user_id' => User::all()->random()->id,
        ];
    }
}

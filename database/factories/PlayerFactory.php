<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $team = Team::factory()->create();
        return [
            "teams_id"  =>  $team->id,
            "name"      =>  "Iqbal Sonata",
            "number"    =>  27,
            "position"  =>  "PG",
            "weight"    =>  52,
            "height"    =>  166,
            "age"       =>  19,
        ];
    }
}

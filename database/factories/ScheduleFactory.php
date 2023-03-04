<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $teamHome = Team::factory()->create();
        $teamAway = Team::factory()->create();
        return [
            'team_home_id' => $teamHome->id,
            'team_away_id' => $teamAway->id,
            'day'          => 'Thursday',
            'time'         => '16:30',
            'pool'         => 'A',
            'date'         => '2023-02-23',
        ];
    }
}

<?php

namespace Tests\Feature;

use App\Models\Schedule;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiSchedulesControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testValidGetSchedules()
    {
        Schedule::factory()->create();
        $this->get('/api/v1/schedules')
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK',
            ])->assertJsonCount(3)
            ->assertSeeText('homeId')
            ->assertSeeText('home')
            ->assertSeeText('awayId')
            ->assertSeeText('away');
    }

    public function testValidGetSchedulesByDate()
    {
        Schedule::factory()->create();
        $this->get('api/v1/schedules?date=2023-02-23')
            ->assertSuccessful()
            ->assertSeeText('23-02-2023')
            ->assertSeeText('Thursday')
            ->assertSeeText('16:30');
    }
    public function testInvalidGetSchedulesByDate()
    {
        Schedule::factory()->create();
        $this->get('api/v1/schedules?date=25-02-2023')
            ->assertSuccessful()
            ->assertDontSeeText('Thursday')
            ->assertDontSee('16:30');
    }

    public function testValidCreateSchedule()
    {
        $teamHome = Team::factory()->create();
        $teamAway = Team::factory()->create();
        $this->post('api/v1/schedules', [
            'team_home_id' => $teamHome->id,
            'team_away_id' => $teamAway->id,
            'day'          => 'Thursday',
            'time'         => "16:30",
            'date'         => "2022-02-17",
            'pool'         => 'A'
        ])->assertCreated()
            ->assertJson([
                'statusCode' => 201,
                'message'    => 'CREATED'
            ]);
        $this->assertDatabaseHas('schedules', [
            'team_home_id' => $teamHome->id,
            'team_away_id' => $teamAway->id,
            'day'          => 'Thursday',
            'time'         => '16:30',
            'date'         => "2022-02-17"
        ]);
    }

    public function testValidationCreateScheduleWorks()
    {
        $teamHome = Team::factory()->create();
        $teamAway = Team::factory()->create();
        $this->post('api/v1/schedules', [
            'team_home_id' => $teamHome->id,
            'team_away_id' => $teamAway->id,
            'day'          => 'Thursday',
            'date'         => '1609',
            'time'         => 'test',
            'pool'         => 'N'
        ])->assertStatus(302);
    }

    public function testValidGetSpecificScheduleByTeamSlug()
    {
        $this->withoutExceptionHandling();
        $schedule = Schedule::factory()->create();
        $team = Team::firstWhere('id', $schedule->team_home_id);
        $this->getJson("api/v1/schedules/$team->slug")
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK'
            ])
            ->assertSeeText('16:30')
            ->assertSeeText('A')
            ->assertSeeText('Thursday');
    }

    public function testSpecificScheduleNotFound()
    {
        $this->getJson("api/v1/schedules/asdada")
            ->assertNotFound();
    }

    public function testDeleteScheduleWorks()
    {
        $schedule = Schedule::factory()->create();
        $this->deleteJson("api/v1/schedules/$schedule->id")
            ->assertSuccessful();

        $this->assertDatabaseMissing('schedules', [
            'time' => '16:30',
            'pool' => 'A'
        ]);
    }
}

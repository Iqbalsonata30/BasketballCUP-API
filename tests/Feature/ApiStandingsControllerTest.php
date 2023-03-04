<?php

namespace Tests\Feature;

use App\Models\Standing;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiStandingsControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testStandingTriggerWorks()
    {
        $team = Team::factory()->create();
        $this->assertDatabaseHas('standings', [
            'teams_id'    => $team->id,
            'total_win'   => 0,
            'total_lose'  => 0,
            'total_match' => 0,
            'winrate'     => 0,
            'pool'        => 'N',
            'gender'      => 'Putra'
        ]);
        $this->assertDatabaseCount('standings', 1);
    }

    public function testValidGetDataStanding()
    {
        Team::factory()->create();
        $this->get('/api/v1/standings')
            ->assertSuccessful()
            ->assertJsonCount(3)
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK'
            ])
            ->assertSeeText('N')
            ->assertSeeText(0);
    }

    public function testChangePoolStandingWorks()
    {
        $team = Team::factory()->create();
        $standing = Standing::firstWhere('teams_id', $team->id);
        $this->put("/api/v1/standings/$standing->id", [
            'pool' => 'A',
            'team_win' => 40
        ])
            ->assertSuccessful()
            ->assertJsonCount(3)
            ->assertSeeText('A');
    }
    public function testValidationChangePoolStandingWorks()
    {
        $team = Team::factory()->create();
        $standing = Standing::firstWhere('teams_id', $team->id);
        $this->put("/api/v1/standings/$standing->id", [
            'pool' => '34343'
        ])->assertUnprocessable()
            ->assertJsonCount(3);
    }

    public function testInvalidChangePoolStanding()
    {
        $this->put('api/v1/standings/3')
            ->assertNotFound()
            ->assertJsonCount(3)
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND'
            ]);
    }
}

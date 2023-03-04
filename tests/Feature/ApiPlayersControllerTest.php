<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiPlayersControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testValidDetailPlayers()
    {
        $team = Team::factory()->create();
        Player::factory()->create();
        $this->get("/api/v1/players/$team->slug")
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK',
            ]);
    }

    public function testInvalidGetDetailPlayers()
    {
        $this->get("/api/v1/players/2")
            ->assertNotFound()
            ->assertJsonCount(3)
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Players not found.'
            ]);
    }

    public function testValidCreatingPlayer()
    {
        $this->withoutExceptionHandling();
        $team = Team::factory()->create();
        $this->post('/api/v1/players', [
            'teams_id'  => $team->id,
            'name'      => 'Iqbal Sonata',
            'number'    => 27,
            'position'  => 'PG',
            'height'    => 180,
            'weight'    => 52,
            'age'       => 19
        ])->assertCreated()
            ->assertJson([
                'statusCode' => 201,
                'message'    => 'CREATED'
            ]);
    }

    public function testInvalidCreatingPlayer()
    {
        $this->post('/api/v1/players', [
            'teams_id' => 3,
            'name'  => 'Iqbal Sonata'
        ])->assertStatus(302)
            ->assertInvalid([
                'number'    => "The number field is required.",
                'position'  => "The position field is required.",
                'height'    => "The height field is required.",
                'weight'    => "The weight field is required.",
                'age'       => "The age field is required."
            ]);
    }

    public function testValidDeletingPlayer()
    {
        $player = Player::factory()->create();
        $this->delete("api/v1/players/$player->id")
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK'
            ])
            ->assertJsonCount(2);
        $this->assertDatabaseMissing('players', [
            'name'  => 'Iqbal Sonata',
            'number' => 27
        ]);
    }

    public function testInvalidDeletingPlayer()
    {
        $this->delete("api/v1/players/1")
            ->assertNotFound()
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'      => 'Players not found.'
            ])
            ->assertJsonCount(3);
    }

    public function testValidUpdatingPlayer()
    {
        $player = Player::factory()->create();
        $this->put("api/v1/players/$player->id", [
            'name'  => 'Uday Saydina',
            'number' => 8
        ])->assertSuccessful()
            ->assertJsonCount(3)
            ->assertSeeText('Uday Saydina')
            ->assertSeeText(8);
    }
    public function testInvalidUpdatingPlayer()
    {
        $this->put('api/v1/players/1', [
            'name'  => 'Uday Saydina',
            'number' => 8
        ])->assertNotFound()
            ->assertJsonCount(3);
    }
}

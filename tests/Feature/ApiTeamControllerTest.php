<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTeamControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testGetAllTeamByGenderPutra()
    {
        Team::create([
            'team_name'     => 'SMAN 1 Mandau',
            'slug'          => 'sman-1-mandau',
            'team_logo'     => 'asdada',
            'team_gender'   => 'Putra'
        ]);
        $this->get('/api/v1/teams')
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'   => 'OK',
            ])
            ->assertJsonCount(3)
            ->assertSeeText('sman-1-mandau')
            ->assertSeeText('asdada')
            ->assertSeeText('Putra');
    }
    public function testGetAllTeamByGenderPutri()
    {
        Team::create([
            'team_name'     => 'SMAN 1 Mandau',
            'slug'          => 'sman-1-mandau',
            'team_logo'     => 'asdada',
            'team_gender'   => 'Putri'
        ]);
        $this->get('/api/v1/teams?gender=Putri')
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK',
            ])
            ->assertJsonCount(3)
            ->assertSeeText('sman-1-mandau')
            ->assertSeeText('asdada')
            ->assertSeeText('Putri');
    }

    public function testValidAddTeam()
    {
        $file = UploadedFile::fake()->image('avatar.png');
        $response = $this->post('api/v1/teams', [
            'team_name'     => 'test 1 mandau',
            'team_logo'     => $file,
            'team_gender'   => 'Putra'
        ]);
        $response->assertSuccessful();
        $this->assertEquals($file->hashName(), Team::latest()->first()->team_logo);
    }
    public function testInvalidAddTeam()
    {
        $this->post('api/v1/teams', [
            'team_logo' => 'test'
        ])
            ->assertStatus(302)
            ->assertInvalid([
                'team_name'     => 'The team name field is required.',
                'team_logo'     => 'The team logo must be an image.',
                'team_logo'     => 'The team logo must be a file of type: jpg, jpeg, png.',
                'team_gender'   => 'The team gender field is required.'
            ]);
    }
    public function testValidEnumValidationTeamGender()
    {
        $this->post('api/v1/teams', [
            'team_name'      => 'hahha',
            'team_logo'      => 'test',
            'team_gender'    => 'Male'
        ])
            ->assertStatus(302)
            ->assertInvalid([
                'team_gender'   => 'The team gender must be one of the following: Putra, Putri'
            ]);
    }

    public function testValidUpdatedAllDataTeam()
    {
        $team = Team::factory()->create();
        $file = UploadedFile::fake()->image('avatar.png');
        $this->put("api/v1/teams/$team->id", [
            'team_name'     => 'File 1',
            'team_gender'   => 'Putri',
            'team_logo'     => $file
        ])
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => "OK"
            ])->assertSeeText('File 1')
            ->assertSeeText('Putri')
            ->assertSeeText($file->hashName());
    }
    public function testValidUpdatedSeparateDataTeam()
    {
        $team = Team::factory()->create();
        $this->put("api/v1/teams/$team->id", [
            'team_name'     => 'Revisi',
            'team_gender'   => 'Putra',
        ])
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => "OK"
            ])->assertSeeText('Revisi')
            ->assertSeeText('Putra');
    }

    public function testValidationUpdateTeamWorks()
    {
        $team = Team::factory()->create();
        $this->put("api/v1/teams/$team->id", [
            'team_logo' => 'test',
            'team_gender' => 'Revisi'
        ])
            ->assertInvalid([
                'team_logo'   => 'The team logo must be an image.',
                'team_gender' => 'The team gender must be one of the following: Putra, Putri',
            ]);
    }

    public function testSuccesfullyDeleteTeam()
    {
        $team = Team::factory()->create();
        $this->delete("/api/v1/teams/$team->id")
            ->assertSuccessful()
            ->assertJson([
                'statusCode' => 200,
                'message'    => 'OK'
            ]);
        $this->assertDatabaseMissing('teams', ['team_name' => 'SMAN 1 Mandau']);
    }
    public function testInvalidDeleteTeam()
    {
        $this->delete("/api/v1/teams/1")
            ->assertNotFound()
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
            ])
            ->assertJsonCount(3);
    }

    public function testInvalidUpdatingTeam()
    {
        $this->put("/api/v1/teams/1")
            ->assertNotFound()
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
            ])
            ->assertJsonCount(3);
    }
}

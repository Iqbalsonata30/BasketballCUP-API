<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    public function testNotFoundApiCorrectly()
    {
        $this->get('api/v1/team')
            ->assertJson([
                'statusCode' => 404,
                'message'    => 'NOT FOUND',
                'error'     => 'Objects not found.'
            ])
            ->assertJsonCount(3);
    }

    public function testNotFoundWebCorrectly()
    {
        $this->get('/test')
            ->assertNotFound();
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnauthorizedRestApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUnauthorizedGetUserPeopleFails()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ]) ->get('/api/v1/people');


        $response->assertStatus(401);
    }
}

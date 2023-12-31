<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    public function test_login(): void
    {
        \Artisan::call('passport:install');
        $client = DB::table('oauth_clients')->where('password_client', 1)->first();

        $taskPayload = [
            'grant_type' => 'email',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'user_email' => 'eh.mansoori@gmail.com',
            'user_password' => '12345678',
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . env('APP_TEST_TOKEN'),
            'Accept' => 'application/json',
        ])
            ->json('post', '/oauth/token', $taskPayload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token'
            ]);
    }
}

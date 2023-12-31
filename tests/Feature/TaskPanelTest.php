<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TaskPanelTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    private function getSecretToken()
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

        $response = $this->postJson('/oauth/token', $taskPayload);
        return  $response['access_token'];
    }

    public function test_create_task(): void
    {

       $accessToken =  $this->getSecretToken();

        $taskPayload = [
            'name' => $this->faker()->name,
            'description' => $this->faker()->paragraph
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ])
            ->json('post', '/api/v1/task', $taskPayload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }

    public function test_update_task(): void
    {

        $accessToken =  $this->getSecretToken();

        $user = User::query()->where('email', 'eh.mansoori@gmail.com')->first();
        if (!$user) {
            $this->seed(UserSeeder::class);
        }

        $taskPayload = [
            'name' => $this->faker()->name,
            'description' => $this->faker()->paragraph,
            'reporter_id' => $user->id
        ];

        $task = Task::query()->create($taskPayload);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
        ])
            ->json('put', '/api/v1/task/update/' . $task->id, $taskPayload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }
}

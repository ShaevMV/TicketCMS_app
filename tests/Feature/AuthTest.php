<?php

namespace Tests\Feature;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testExample(): void
    {
        $urlOauthToken = env('APP_URL_DOCKER', 'http://172.17.0.1/') . 'api/auth/login';
        $http = new Client();
        /** @var User $user */
        $user = User::first();
        $response = $http->post($urlOauthToken, [
            'form_params' => [
                'email' => $user->email,
                'password' => 'password',
            ],
        ]);
        $result = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('token_type', $result);
        $this->assertArrayHasKey('expires_in', $result);
        $this->assertArrayHasKey('access_token', $result);
    }

}

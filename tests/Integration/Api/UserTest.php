<?php

namespace App\Tests\Integration\Api;

use App\Tests\Utilities\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class UserTest extends ApiTestCase
{
    public function test_get_users_collection(): void
    {
        $response  = $this->client->request('GET', '/users');

        $this->assertResponse($response, '/User/get_users');
    }

    public function test_get_user(): void
    {
        $response = $this->client->request('GET', '/users/1');

        $this->assertResponse($response, '/User/get_user_1');
    }

    public function test_post_user(): void
    {
        $response = $this->client->request('POST', '/users' , [
            'json' => [
                'firstName' => 'Jim',
                'lastName' => 'Rick',
                'age' => 55,
                'email' => 'email@email',
            ]
        ]);

        $this->assertResponse($response, '/User/post_user', Response::HTTP_CREATED);
    }

    public function test_put_user(): void
    {
        $response = $this->client->request('PUT', '/users/1' , [
            'json' => [
                'firstName' => 'Jim',
            ]
        ]);

        $this->assertResponse($response, '/User/put_user', Response::HTTP_NO_CONTENT);
    }
}
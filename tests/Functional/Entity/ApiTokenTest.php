<?php

namespace App\Tests\Functional\Entity;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Tests\Utilities\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ApiTokenTest extends ApiTestCase
{
    private ApiTokenRepositoryInterface $apiTokenRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiTokenRepository = $this->getContainer()->get(ApiTokenRepositoryInterface::class);
    }

    public function test_unauthorised_with_invalid_token(): void
    {
        $response  = $this->client->request('GET', '/users', [
            'headers' => [
                'Authorization' => 'Bearer TOKEN',
            ],
        ]);

        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function test_authorised_with_valid_token(): void
    {
        /** @var ApiToken $token */
        $token = $this->apiTokenRepository->findAll()[0];

        $response  = $this->client->request('GET', '/users', [
            'headers' => [
                'Authorization' => sprintf(
                    'Bearer %s',
                    $token->getToken()
                )
            ],
        ]);

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
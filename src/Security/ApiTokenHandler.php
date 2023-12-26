<?php

namespace App\Security;

use App\Entity\ApiToken;
use App\Repository\ApiTokenRepositoryInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ApiTokenRepositoryInterface $apiTokenRepository
    ) {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        $token = $this->apiTokenRepository->find($accessToken);

        if (!$token instanceof ApiToken) {
            throw new BadCredentialsException();
        }

//        if ($token->is)

        return new UserBadge($token->getUser()->getUserIdentifier());
    }
}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack
    ) {
    }

    public function __invoke($data)
    {
        $response = $this->requestStack->getCurrentRequest();
    }
}
<?php

namespace App\Denormalizer;

use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    /**
     * @inerhitDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): mixed
    {
        return $data;
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        return false;
        if ($context['operation'] instanceof Post) {
            return false;
        }


        return is_array($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }
}
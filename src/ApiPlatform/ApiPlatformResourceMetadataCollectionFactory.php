<?php

namespace App\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Operations;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\ResourceMetadataCollection;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: 'api_platform.metadata.resource.metadata_collection_factory')]
class ApiPlatformResourceMetadataCollectionFactory implements ResourceMetadataCollectionFactoryInterface
{
    public function __construct(
        private ResourceMetadataCollectionFactoryInterface $inner
    ) {
    }

    public function create(string $resourceClass): ResourceMetadataCollection
    {
        $resourceMetadataCollection = $this->inner->create($resourceClass);

        if ('App\Entity\User' === $resourceClass) {
        /** @var ApiResource $resourceMetadata */
            foreach($resourceMetadataCollection as $key => $resourceMetadata) {
                $resourceMetadata = $resourceMetadata->withShortName('test');
                if ($resourceMetadata->getOperations()) {
                    $resourceMetadata = $resourceMetadata->withOperations($this->getTransformedOperations($resourceMetadata->getOperations(), $resourceMetadata));
                }

                $resourceMetadataCollection[$key] = $resourceMetadata;
            }
        }

        return $resourceMetadataCollection;
    }

    private function getTransformedOperations(Operations|array $operations, ApiResource $resourceMetadata)
    {
        $operations->add('post', new Post());

        return $operations;

    }
}
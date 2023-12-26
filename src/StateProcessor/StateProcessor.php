<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Exceptions\StateProcessor\StateProcessorOperationNotSupported;

class StateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private ProcessorInterface $removeProcessor,
    ) {
    }

    /**
     * @inheritDoc
     * @throws StateProcessorOperationNotSupported
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return match (get_class($operation)) {
            Post::class => $this->processPost($data, $operation, $uriVariables, $context),
            Put::class => $this->processPut($data, $operation, $uriVariables, $context),
            Delete::class => $this->processDelete($data, $operation, $uriVariables, $context),
            default => throw new StateProcessorOperationNotSupported(sprintf(
                'Operaction %s not supported in %s',
                get_class($operation),
                static::class
            )),
        };
    }

    protected function processPost(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->persistProcessor->process(
            $this->persist($data),
            $operation,
            $uriVariables,
            $context
        );
    }

    protected function processPut(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->persistProcessor->process(
            $this->persist($data),
            $operation,
            $uriVariables,
            $context
        );
    }

    protected function processDelete(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->removeProcessor->process($data, $operation, $uriVariables, $context);
    }

    protected function persist(mixed $data): mixed
    {
        return $data;
    }
}
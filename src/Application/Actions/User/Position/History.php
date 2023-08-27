<?php

declare(strict_types=1);

namespace App\Application\Actions\User\Position;

use Psr\Http\Message\ResponseInterface as Response;

class History extends \App\Application\Actions\User\Action
{
    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     */
    protected function action(): Response
    {
        try {
            $user = $this->userRepository->get((int) $this->resolveArg('id'));
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $this->respondWithData(['history' => $user->positions]);
    }
}
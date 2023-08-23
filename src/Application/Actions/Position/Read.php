<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

use Psr\Http\Message\ResponseInterface as Response;

class Read extends \App\Application\Actions\Position\Action
{
    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     */
    protected function action(): Response
    {
        try {
            $position = $this->positionRepository->get($this->resolveArg('code'));
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $this->respondWithData(['position' => $position]);
    }
}

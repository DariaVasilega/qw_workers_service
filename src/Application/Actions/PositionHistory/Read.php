<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

use Psr\Http\Message\ResponseInterface as Response;

class Read extends \App\Application\Actions\PositionHistory\Action
{
    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     */
    protected function action(): Response
    {
        try {
            $positionHistory = $this->historyRepository->get((int) $this->resolveArg('id'));
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $this->respondWithData(['history' => $positionHistory]);
    }
}

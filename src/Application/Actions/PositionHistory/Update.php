<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

use Psr\Http\Message\ResponseInterface as Response;

class Update extends \App\Application\Actions\PositionHistory\Store
{
    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $historyData = $this->getFormData();
        $positionHistory = $this->init($historyData);

        $this->save($positionHistory->fill($historyData));

        return $this->sendResponse($positionHistory);
    }

    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     */
    protected function init(array $historyData): \App\Domain\PositionHistory
    {
        try {
            $position = $this->historyRepository->get((int) $this->resolveArg('id'));
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $position;
    }

    /**
     * @inheritDoc
     */
    protected function sendResponse(\App\Domain\PositionHistory $positionHistory): Response
    {
        return $this->respondWithData(['message' => $this->translator->get('action.update.success')]);
    }
}

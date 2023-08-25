<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Store extends \App\Application\Actions\PositionHistory\Action
{
    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainRecordNotSavedException
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     */
    protected function action(): Response
    {
        $historyData = $this->getFormData();

        $positionHistory = $this->init($historyData);
        $this->save($positionHistory);

        return $this->sendResponse($positionHistory);
    }

    /**
     * Save
     *
     * @throws \App\Domain\DomainException\DomainException
     */
    protected function save(\App\Domain\PositionHistory $positionHistory): void
    {
        try {
            $this->historyRepository->save($positionHistory);
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }
    }

    /**
     * Init
     *
     * @param array $historyData
     * @return \App\Domain\PositionHistory
     */
    abstract protected function init(array $historyData): \App\Domain\PositionHistory;

    /**
     * Send response
     *
     * @param \App\Domain\PositionHistory $positionHistory
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \JsonException
     */
    abstract protected function sendResponse(\App\Domain\PositionHistory $positionHistory): Response;
}

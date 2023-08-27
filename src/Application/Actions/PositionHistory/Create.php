<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

use Psr\Http\Message\ResponseInterface as Response;

class Create extends \App\Application\Actions\PositionHistory\Store
{
    /**
     * @inheritDoc
     */
    protected function init(array $historyData): \App\Domain\PositionHistory
    {
        /** @var \App\Domain\PositionHistory $positionHistory */
        $positionHistory = \App\Domain\PositionHistory::query()->make($historyData);

        return $positionHistory;
    }

    /**
     * @inheritDoc
     */
    protected function sendResponse(\App\Domain\PositionHistory $positionHistory): Response
    {
        return $this->respondWithData([
            'message' => $this->translator->get('action.create.success'),
            'history' => [
                'id' => $positionHistory->id, /** @phpstan-ignore-line */
            ],
        ]);
    }
}

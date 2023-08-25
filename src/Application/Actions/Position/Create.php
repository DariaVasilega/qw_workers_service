<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

use Psr\Http\Message\ResponseInterface as Response;

class Create extends \App\Application\Actions\Position\Store
{
    /**
     * @inheritDoc
     */
    protected function init(array $positionData): \App\Domain\Position
    {
        /** @var \App\Domain\Position $position */
        $position = \App\Domain\Position::query()->make($positionData);

        return $position;
    }

    /**
     * @inheritDoc
     */
    protected function sendResponse(\App\Domain\Position $position): Response
    {
        return $this->respondWithData([
            'message' => $this->translator->get('action.create.success'),
            'position' => [
                'code' => $position->code,
            ],
        ]);
    }
}

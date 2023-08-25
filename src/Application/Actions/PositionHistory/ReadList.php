<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

use Psr\Http\Message\ResponseInterface as Response;

class ReadList extends \App\Application\Actions\PositionHistory\Action
{
    /**
     * @var \App\Factory\SearchCriteriaFactory $criteriaFactory
     */
    private \App\Factory\SearchCriteriaFactory $criteriaFactory;

    public function __construct(
        \App\Infrastructure\Filesystem\Log\PositionHistoryActionLogger $logger,
        \Illuminate\Translation\Translator $translator,
        \App\Domain\PositionHistoryRepositoryInterface $historyRepository,
        \App\Factory\SearchCriteriaFactory $criteriaFactory
    ) {
        parent::__construct(
            $logger,
            $translator,
            $historyRepository
        );

        $this->criteriaFactory = $criteriaFactory;
    }

    /**
     * @inheritDoc
     * @throws \App\Domain\DomainException\DomainException
     * @throws \JsonException
     * @throws \Exception
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function action(): Response
    {
        try {
            $searchResult = $this->historyRepository->getList(
                $this->criteriaFactory->create([
                    'model' => \App\Domain\PositionHistory::query()->make(),
                    'request' => \Illuminate\Http\Request::capture(),
                ])
            );
        } catch (\App\Domain\DomainException\DomainException $exception) {
            $this->logger->error($exception);

            throw $exception;
        }

        return $this->respondWithData($searchResult);
    }
}

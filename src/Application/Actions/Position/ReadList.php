<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

use Psr\Http\Message\ResponseInterface as Response;

class ReadList extends \App\Application\Actions\Position\Action
{
    /**
     * @var \App\Factory\SearchCriteriaFactory $criteriaFactory
     */
    private \App\Factory\SearchCriteriaFactory $criteriaFactory;

    public function __construct(
        \App\Infrastructure\Filesystem\Log\PositionActionLogger $logger,
        \Illuminate\Translation\Translator $translator,
        \App\Domain\PositionRepositoryInterface $userRepository,
        \App\Factory\SearchCriteriaFactory $criteriaFactory
    ) {
        parent::__construct(
            $logger,
            $translator,
            $userRepository
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
            $searchResult = $this->positionRepository->getList(
                $this->criteriaFactory->create([
                    'model' => \App\Domain\Position::query()->make(),
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

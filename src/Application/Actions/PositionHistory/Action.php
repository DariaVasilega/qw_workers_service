<?php

declare(strict_types=1);

namespace App\Application\Actions\PositionHistory;

abstract class Action extends \App\Application\Actions\Action
{
    /**
     * @var \App\Domain\PositionHistoryRepositoryInterface $historyRepository
     */
    protected \App\Domain\PositionHistoryRepositoryInterface $historyRepository;

    /**
     * @param \App\Infrastructure\Filesystem\Log\PositionHistoryActionLogger $logger
     * @param \Illuminate\Translation\Translator $translator
     * @param \App\Domain\PositionHistoryRepositoryInterface $historyRepository
     */
    public function __construct(
        \App\Infrastructure\Filesystem\Log\PositionHistoryActionLogger $logger,
        \Illuminate\Translation\Translator $translator,
        \App\Domain\PositionHistoryRepositoryInterface $historyRepository
    ) {
        parent::__construct($logger, $translator);

        $this->historyRepository = $historyRepository;
    }
}

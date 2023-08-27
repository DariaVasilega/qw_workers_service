<?php

declare(strict_types=1);

namespace App\Application\Actions\Position;

abstract class Action extends \App\Application\Actions\Action
{
    /**
     * @var \App\Domain\PositionRepositoryInterface $positionRepository
     */
    protected \App\Domain\PositionRepositoryInterface $positionRepository;

    /**
     * @param \App\Infrastructure\Filesystem\Log\PositionActionLogger $logger
     * @param \Illuminate\Translation\Translator $translator
     * @param \App\Domain\PositionRepositoryInterface $positionRepository
     */
    public function __construct(
        \App\Infrastructure\Filesystem\Log\PositionActionLogger $logger,
        \Illuminate\Translation\Translator $translator,
        \App\Domain\PositionRepositoryInterface $positionRepository
    ) {
        parent::__construct($logger, $translator);

        $this->positionRepository = $positionRepository;
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Persistence;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PositionHistoryRepository extends \App\Infrastructure\Database\Persistence\AbstractRepository implements
    \App\Domain\PositionHistoryRepositoryInterface
{
    protected const SELECTION_KEY = 'histories';

    /**
     * @var \Illuminate\Database\Eloquent\Builder $queryBuilder;
     */
    private \Illuminate\Database\Eloquent\Builder $queryBuilder;

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function init(): void
    {
        $this->queryBuilder = \App\Domain\PositionHistory::query();
    }

    /**
     * @inheritDoc
     */
    public function save(\App\Domain\PositionHistory $positionHistory): bool
    {
        try {
            return $positionHistory->save();
        } catch (\Exception $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotSavedException(
                'repository.error.not_saved',
                (int) $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function get(int $entityId): \App\Domain\PositionHistory
    {
        try {
            /**
             * @var \App\Domain\PositionHistory $positionHistory
             * @phpstan-ignore-next-line
             */
            $positionHistory = $this->queryBuilder->newQuery()->findOrFail($entityId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotFoundException(
                'repository.error.not_found',
                (int) $exception->getCode(),
                $exception
            );
        }

        return $positionHistory;
    }

    /**
     * @inheritDoc
     */
    public function delete(\App\Domain\PositionHistory $positionHistory): bool
    {
        try {
            $positionHistory->delete();
        } catch (\LogicException $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotRemovedException(
                'repository.error.not_removed',
                (int) $exception->getCode(),
                $exception
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $entityId): bool
    {
        $this->delete($this->get($entityId));

        return true;
    }
}

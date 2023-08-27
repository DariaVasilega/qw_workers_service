<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Persistence;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class PositionRepository extends \App\Infrastructure\Database\Persistence\AbstractRepository implements
    \App\Domain\PositionRepositoryInterface
{
    protected const SELECTION_KEY = 'positions';

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
        $this->queryBuilder = \App\Domain\Position::query();
    }

    /**
     * @inheritDoc
     */
    public function save(\App\Domain\Position $position): bool
    {
        try {
            return $position->save();
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
    public function get(string $positionCode): \App\Domain\Position
    {
        try {
            /**
             * @var \App\Domain\Position $position
             * @phpstan-ignore-next-line
             */
            $position = $this->queryBuilder->newQuery()->findOrFail($positionCode);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotFoundException(
                'repository.error.not_found',
                (int) $exception->getCode(),
                $exception
            );
        }

        return $position;
    }

    /**
     * @inheritDoc
     */
    public function delete(\App\Domain\Position $position): bool
    {
        try {
            $position->delete();
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
    public function deleteByCode(string $positionCode): bool
    {
        $this->delete($this->get($positionCode));

        return true;
    }
}

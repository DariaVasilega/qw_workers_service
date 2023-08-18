<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Persistence;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UserRepository extends \App\Infrastructure\Database\Persistence\AbstractRepository implements
    \App\Domain\UserRepositoryInterface
{
    protected const SELECTION_KEY = 'users';

    /**
     * @var \Illuminate\Database\Eloquent\Builder $queryBuilder;
     */
    private \Illuminate\Database\Eloquent\Builder $queryBuilder;

    /**
     * @inheritDoc
     */
    protected function init(): void
    {
        /**
         * @phpmd-ignore-next-line
         */
        $this->queryBuilder = \App\Domain\User::query();
    }

    /**
     * @inheritDoc
     */
    public function save(\App\Domain\User $user): bool
    {
        try {
            return $user->save();
        } catch (\Exception $exception) {
            $resetIncrement = $this->queryBuilder->newQuery()->max('id') - 1;

            $fixIncrementQuery = <<<SQL
ALTER TABLE `{$user->getTable()}` AUTO_INCREMENT=$resetIncrement;
SQL;

            $this->queryBuilder->newQuery()->getConnection()->statement($fixIncrementQuery);

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
    public function get(int $userId): \App\Domain\User
    {
        try {
            /**
             * @var \App\Domain\User $user
             * @phpstan-ignore-next-line
             */
            $user = $this->queryBuilder->newQuery()->findOrFail($userId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotFoundException(
                'repository.error.not_found',
                (int) $exception->getCode(),
                $exception
            );
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): \App\Domain\User
    {
        try {
            /** @var \App\Domain\User|null $user */
            $user = $this->queryBuilder->newQuery()->where('email', $email)->get()->firstOrFail();
        } catch (\Illuminate\Support\ItemNotFoundException $exception) {
            throw new \App\Domain\DomainException\DomainRecordNotFoundException(
                'repository.error.not_found',
                (int) $exception->getCode(),
                $exception
            );
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function delete(\App\Domain\User $user): bool
    {
        try {
            $user->delete();
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
    public function deleteById(int $userId): bool
    {
        $this->delete($this->get($userId));

        return true;
    }
}

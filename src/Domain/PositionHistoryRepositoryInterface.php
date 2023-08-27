<?php

declare(strict_types=1);

namespace App\Domain;

interface PositionHistoryRepositoryInterface extends \App\Domain\RepositoryInterface
{
    /**
     * @param \App\Domain\PositionHistory $positionHistory
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotSavedException
     */
    public function save(\App\Domain\PositionHistory $positionHistory): bool;

    /**
     * @param int $entityId
     * @return \App\Domain\PositionHistory
     * @throws \App\Domain\DomainException\DomainRecordNotFoundException
     */
    public function get(int $entityId): \App\Domain\PositionHistory;

    /**
     * @param \App\Domain\PositionHistory $positionHistory
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotRemovedException
     */
    public function delete(\App\Domain\PositionHistory $positionHistory): bool;

    /**
     * @param int $entityId
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotFoundException
     * @throws \App\Domain\DomainException\DomainRecordNotRemovedException
     */
    public function deleteById(int $entityId): bool;
}

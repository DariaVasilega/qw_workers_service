<?php

declare(strict_types=1);

namespace App\Domain;

interface PositionRepositoryInterface extends \App\Domain\RepositoryInterface
{
    /**
     * @param \App\Domain\Position $position
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotSavedException
     */
    public function save(\App\Domain\Position $position): bool;

    /**
     * @param string $positionCode
     * @return \App\Domain\Position
     * @throws \App\Domain\DomainException\DomainRecordNotFoundException
     */
    public function get(string $positionCode): \App\Domain\Position;

    /**
     * @param \App\Domain\Position $position
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotRemovedException
     */
    public function delete(\App\Domain\Position $position): bool;

    /**
     * @param string $positionCode
     * @return bool
     * @throws \App\Domain\DomainException\DomainRecordNotFoundException
     * @throws \App\Domain\DomainException\DomainRecordNotRemovedException
     */
    public function deleteByCode(string $positionCode): bool;
}

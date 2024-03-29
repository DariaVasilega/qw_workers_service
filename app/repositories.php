<?php

declare(strict_types=1);

use App\Application\Directory\Locale;
use App\Application\Directory\LocaleInterface;
use App\Application\SearchCriteriaInterface;
use App\Application\SearchResultInterface;
use App\Application\SearchResultPageInterface;
use App\Domain\PositionHistoryRepositoryInterface;
use App\Domain\PositionRepositoryInterface;
use App\Domain\UserRepositoryInterface;
use App\Infrastructure\Database\Persistence\PositionHistoryRepository;
use App\Infrastructure\Database\Persistence\PositionRepository;
use App\Infrastructure\Database\Persistence\UserRepository;
use App\Infrastructure\Database\Query\SearchCriteria;
use App\Infrastructure\SearchResult;
use App\Infrastructure\SearchResultPage;
use DI\ContainerBuilder;

use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LocaleInterface::class => autowire(Locale::class),
        SearchCriteriaInterface::class => autowire(SearchCriteria::class),
        SearchResultInterface::class => autowire(SearchResult::class),
        SearchResultPageInterface::class => autowire(SearchResultPage::class),
        UserRepositoryInterface::class => autowire(UserRepository::class),
        PositionRepositoryInterface::class => autowire(PositionRepository::class),
        PositionHistoryRepositoryInterface::class => autowire(PositionHistoryRepository::class),
    ]);
};

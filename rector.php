<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\CodeQuality\Rector\ClassMethod\ActionSuffixRemoverRector;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Sulu\Rector\Set\SuluLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/Admin',
        __DIR__ . '/Api',
        __DIR__ . '/Controller',
        __DIR__ . '/DependencyInjection',
        __DIR__ . '/Entity',
        __DIR__ . '/Preview',
        __DIR__ . '/Repository',
        __DIR__ . '/Resources',
        __DIR__ . '/Routing',
        __DIR__ . '/Service',
    ]);

    $rectorConfig->phpstanConfigs([
        __DIR__ . '/phpstan.neon',
        // rector does not load phpstan extension automatically so require them manually here:
        __DIR__ . '/vendor/phpstan/phpstan-doctrine/extension.neon',
        __DIR__ . '/vendor/phpstan/phpstan-symfony/extension.neon',
    ]);

    // basic rules
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_83,
    ]);

    // symfony rules
    $rectorConfig->symfonyContainerPhp(__DIR__ . '/var/cache/website/dev/App_KernelDevDebugContainer.xml');

    $rectorConfig->sets([
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
        // SymfonyLevelSetList::UP_TO_SYMFONY_64,
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
    ]);

    // doctrine rules
    $rectorConfig->sets([
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
    ]);

    // sulu rules
    $rectorConfig->sets([
        SuluLevelSetList::UP_TO_SULU_25,
    ]);

    // Skip
    $rectorConfig->skip([
        ActionSuffixRemoverRector::class,
    ]);
};

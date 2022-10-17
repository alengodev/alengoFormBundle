<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) Alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Tests\Application;

use Alengo\Bundle\AlengoFormBundle\AlengoFormBundle;
use Sulu\Bundle\TestBundle\Kernel\SuluTestKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class Kernel extends SuluTestKernel
{
    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        /** @var BundleInterface[] $bundles */
        $bundles = parent::registerBundles();
        $bundles[] = new AlengoFormBundle();

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        parent::registerContainerConfiguration($loader);
        $loader->load(__DIR__.'/config/config.yml');
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}

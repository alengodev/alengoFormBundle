<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Routing;

use Alengo\Bundle\AlengoFormBundle\Controller\FormDataController;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Sulu\Route\Application\Routing\Matcher\RouteDefaultsProviderInterface;
use Sulu\Route\Domain\Model\Route;

class FormDataRouteDefaultsProvider implements RouteDefaultsProviderInterface
{
    public function __construct(
        private readonly FormDataRepository $formDataRepository,
    ) {
    }

    public static function getResourceKey(): string
    {
        return FormData::RESOURCE_KEY;
    }

    public function getDefaults(Route $route): array
    {
        return [
            '_controller' => FormDataController::class . '::indexAction',
            'formData' => $this->formDataRepository->findOneBy(['id' => $route->getResourceId(), 'locale' => $route->getLocale()]),
        ];
    }
}

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
use Sulu\Bundle\RouteBundle\Routing\Defaults\RouteDefaultsProviderInterface;

class FormDataRouteDefaultsProvider implements RouteDefaultsProviderInterface
{
    public function __construct(
        private readonly FormDataRepository $formDataRepository,
    ) {
    }

    public function getByEntity($entityClass, $id, $locale = '', $object = null): array
    {
        return [
            '_controller' => FormDataController::class . '::indexAction',
            'formData' => $object ?? $this->formDataRepository->findOneBy(['id' => $id, 'locale' => $locale]),
        ];
    }

    public function isPublished($entityClass, $id, $locale): bool
    {
        return true;
    }

    public function supports($entityClass): bool
    {
        return FormData::class === $entityClass;
    }
}

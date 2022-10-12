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

namespace Alengo\Bundle\AlengoFormBundle\Routing;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Sulu\Bundle\RouteBundle\Routing\Defaults\RouteDefaultsProviderInterface;

class FormDataRouteDefaultsProvider implements RouteDefaultsProviderInterface
{
    public function __construct(protected FormDataRepository $formDataRepository)
    {
    }

    public function getByEntity($entityClass, $id, $locale = '', $object = null)
    {
        return [
            '_controller' => 'alengo_form.controller.website::indexAction',
            'formData' => $object ?: $this->formDataRepository->findOneBy(['id' => $id, 'locale' => $locale]),
        ];
    }

    public function isPublished($entityClass, $id, $locale)
    {
        return true;
    }

    public function supports($entityClass)
    {
        return FormData::class === $entityClass;
    }
}

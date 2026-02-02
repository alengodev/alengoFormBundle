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

namespace Alengo\Bundle\AlengoFormBundle\Preview;

use Alengo\Bundle\AlengoFormBundle\Controller\FormDataController;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Sulu\Bundle\PreviewBundle\Preview\PreviewContext;
use Sulu\Bundle\PreviewBundle\Preview\Provider\PreviewDefaultsProviderInterface;

class FormDataObjectProvider implements PreviewDefaultsProviderInterface
{
    public function __construct(private readonly FormDataRepository $formDataRepository)
    {
    }

    public function getDefaults(PreviewContext $previewContext): array
    {
        $id = $previewContext->getId();

        if (null === $id) {
            return [];
        }

        $formData = $this->formDataRepository->findOneBy(['id' => $id]);

        if (!$formData instanceof FormData) {
            return [];
        }

        return [
            'formData' => $formData,
            '_controller' => FormDataController::class . '::indexAction',
        ];
    }

    public function updateValues(PreviewContext $previewContext, array $defaults, array $data): array
    {
        $formData = $defaults['formData'] ?? null;

        if (!$formData instanceof FormData) {
            return $defaults;
        }

        if (isset($data['data'])) {
            $formData->setData($data['data']);
        }

        if (isset($data['receiverMail'])) {
            $formData->setReceiverMail($data['receiverMail']);
        }

        if (isset($data['userMail'])) {
            $formData->setUserMail($data['userMail']);
        }

        if (isset($data['category'])) {
            $formData->setCategory($data['category']);
        }

        if (isset($data['comments'])) {
            $formData->setComments($data['comments']);
        }

        return $defaults;
    }

    public function updateContext(PreviewContext $previewContext, array $defaults, array $context): array
    {
        return $defaults;
    }

    public function getSecurityContext(PreviewContext $previewContext): ?string
    {
        return FormData::SECURITY_CONTEXT;
    }
}
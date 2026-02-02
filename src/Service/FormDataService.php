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

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;

class FormDataService implements FormDataInterface
{
    public function __construct(
        private readonly FormDataRepository $formDataRepository,
    ) {
    }

    /**
     * @return array{count: int, data: array<int, array<string, mixed>>}
     */
    public function listFormDataFromRequest(
        string $datefrom,
        string $dateto,
        string $locale,
        string $category,
        string $webspaceKey,
        string $receiverMail,
        string $userMail,
    ): array {
        $data = $this->formDataRepository->listFormData($datefrom, $dateto, $locale, $category, $webspaceKey, $receiverMail, $userMail);

        $formData = \array_map(static fn (FormData $item): array => [
            'id' => $item->getId(),
            'locale' => $item->getLocale(),
            'webspaceKey' => $item->getWebspaceKey(),
            'data' => $item->getData(),
            'receiverMail' => $item->getReceiverMail(),
            'userMail' => $item->getUserMail(),
            'category' => $item->getCategory(),
            'comments' => $item->getComments(),
            'datefrom' => $item->getCreated()?->format('Y-m-d'),
            'dateto' => $item->getCreated()?->format('Y-m-d'),
            'created' => $item->getCreated(),
            'changed' => $item->getChanged(),
        ], $data);

        return [
            'count' => \count($formData),
            'data' => $formData,
        ];
    }
}

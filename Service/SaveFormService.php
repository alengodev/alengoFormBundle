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

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class SaveFormService implements SaveFormInterface
{
    public function __construct(
        private readonly FormDataRepository $repository,
        private readonly FormDataFactory $factory,
        private readonly string $defaultReceiverMail,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function saveFormDataFromRequest(array $data, string $webspace, string $location, string $category, string $receiverMail = null, bool $copy = false): FormData
    {
        $formData = $this->factory->generateFormDataByData($data, $webspace, $location, $category, $receiverMail ?? $this->defaultReceiverMail, $copy);
        $this->repository->save($formData);

        return $formData;
    }

    public function updateFormData(FormData $formData, array $data): FormData
    {
        $formData = $this->factory->updateFormDataByData($formData, $data);
        $this->repository->save($formData);

        return $formData;
    }
}

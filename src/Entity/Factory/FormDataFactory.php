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

namespace Alengo\Bundle\AlengoFormBundle\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

class FormDataFactory
{
    public function generateFormDataByData(
        array $data,
        string $webspaceKey,
        string $locale,
        string $category,
        string $receiverMail,
        bool $copy = false,
    ): FormData {
        $formData = new FormData();
        $formData->setData($data);
        $formData->setReceiverMail($receiverMail);
        $formData->setCreated(new \DateTime());
        $formData->setChanged(new \DateTime());
        $formData->setCopy($copy);
        $formData->setLocale($locale);
        $formData->setWebspaceKey($webspaceKey);
        $formData->setCategory($category);

        $email = $this->getProperty($data, 'email');
        if (null !== $email) {
            $formData->setUserMail($email);
        }

        return $formData;
    }

    public function updateFormDataByData(FormData $formData, array $data): FormData
    {
        $formData->setChanged(new \DateTime());

        $comments = $this->getProperty($data, 'comments');
        if (\is_array($comments)) {
            $formData->setComments($comments);
            $formData->setCountedComments(\count($comments));
        } else {
            $formData->setComments([]);
            $formData->setCountedComments(0);
        }

        return $formData;
    }

    protected function getProperty(array $data, string $key, mixed $default = null): mixed
    {
        return $data[$key] ?? $default;
    }
}

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
    public function generateFormDataByData(array $data, string $webspaceKey, string $location, string $category, string $receiverMail, bool $copy = false): FormData
    {
        $formData = new FormData();
        $formData->setData($data);
        $formData->setReceiverMail($receiverMail);
        $formData->setCreated(new \DateTime());
        $formData->setChanged(new \DateTime());
        $formData->setCopy($copy);
        $formData->setLocale($location);
        $formData->setWebspaceKey($webspaceKey);
        $formData->setCategory($category);

        if ($this->getProperty($data, 'email')) {
            $formData->setUserMail($this->getProperty($data, 'email'));
        }

        return $formData;
    }

    public function updateFormDataByData(FormData $formData, array $data): FormData
    {
        $formData->setChanged(new \DateTime());
        if ($this->getProperty($data, 'comments')) {
            $formData->setComments($this->getProperty($data, 'comments'));
            $formData->setCountedComments(\count($this->getProperty($data, 'comments')));
        } else {
            $formData->setComments([]);
            $formData->setCountedComments(0);
        }

        return $formData;
    }

    /**
     * Return property for key or given default value.
     *
     * @param array $data
     * @param string $key
     * @param string $default
     *
     * @return string|null
     */
    protected function getProperty($data, $key, $default = null)
    {
        if (\array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $default;
    }
}

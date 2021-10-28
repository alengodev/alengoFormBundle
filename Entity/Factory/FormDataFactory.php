<?php

namespace Alengo\Bundle\AlengoFormBundle\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;


class FormDataFactory
{
    public function generateFormDataByData(array $data, string $webspaceKey, string $location, string $category, string $receiverMail): FormData
    {
        $formData = new FormData();
        $formData->setData($data);
        $formData->setReceiverMail($receiverMail);
        $formData->setCreated(new \DateTime());
        $formData->setChanged(new \DateTime());
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
            $formData->setCountedComments(count($this->getProperty($data, 'comments')));

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
     * @return null|string
     */
    protected function getProperty($data, $key, $default = null)
    {
        if (\array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $default;
    }
}
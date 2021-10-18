<?php

namespace Alengo\Bundle\AlengoFormBundle\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

final class FormDataFactory
{
    static function generateFormDataByData(array $data, string $webspaceKey, string $location): FormData
    {
        $formData = new FormData();
        $formData->setData($data);
        $formData->setCreated(new \DateTime());
        $formData->setChanged(new \DateTime());
        $formData->setLocale($location);
        $formData->setWebspaceKey($webspaceKey);

        return $formData;
    }
}
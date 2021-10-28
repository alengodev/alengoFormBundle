<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

interface SaveFormInterface
{
    public function saveFormDataFromRequest(array $data, string $webspace, string $location, string $category, string $receiverMail = NULL, bool $copy = false): FormData;
}
<?php

declare(strict_types=1);

namespace Alengo\Bundle\AlengoFormBundle\Service;

interface FormDataInterface
{
    public function listFormDataFromRequest(string $datefrom, string $dateto, string $locale, string $category, string $webspaceKey, string $receiverMail, string $userMail): array;
}

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

interface FormDataInterface
{
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
    ): array;
}

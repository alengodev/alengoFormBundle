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

interface SaveFormInterface
{
    public function saveFormDataFromRequest(array $data, string $webspace, string $location, string $category, string $receiverMail = null, bool $copy = false): FormData;
}

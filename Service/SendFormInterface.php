<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) Alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

interface SendFormInterface
{
    public function sendFormDataAsMail(FormData $formData, string $template, string $title, string $receiverMail, $xmlTemplate = false, $files = false, $additionalData = false);
}

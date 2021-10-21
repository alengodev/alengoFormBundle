<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

class SendFormService implements SendFormInterface
{

    public function sendFormDataAsMail(FormData $formData, string $template, string $senderMail, string $receiverMail,bool $copy = false)
    {
        // TODO: Implement sendFormDataAsMail() method.
    }
}
<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

interface SendFormInterface
{
    public function sendFormDataAsMail(FormData $formData, string $template, string $title, string $receiverMail);

    public function sendFormDataAsXmlMail(FormData $formData, string $template, string $title, string $receiverMail);
}
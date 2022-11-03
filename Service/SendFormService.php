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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendFormService implements SendFormInterface
{
    private MailerInterface $mailer;
    private string $defaultSenderName;
    private string $defaultSenderMail;

    public function __construct(MailerInterface $mailer, string $defaultSenderName = null, string $defaultSenderMail = null)
    {
        $this->mailer = $mailer;
        $this->defaultSenderName = $defaultSenderName;
        $this->defaultSenderMail = $defaultSenderMail;
    }

    public function sendFormDataAsMail(FormData $formData, string $template, string $title, string $receiverMail, $xmlTemplate = false, $files = false, $additionalData = false)
    {
        $message = (new TemplatedEmail())
            ->from(new Address($this->defaultSenderMail, $this->defaultSenderName))
            ->to(new Address($receiverMail))
            ->replyTo(isset($formData->getData()['email']) ? $formData->getData()['email'] : $this->defaultSenderMail)
            ->subject($title)
            ->htmlTemplate($template)
            ->context([
                'formData' => $formData,
                'data' => $formData->getData(),
                'additionalData' => $additionalData,
            ])
        ;

        if($xmlTemplate) {
            $message->textTemplate($xmlTemplate);
        }

        if (isset($files) && \is_array($files)) {
            foreach ($files as $attachment) {
                $message->attachFromPath($attachment);
            }
        }

        try {
            $this->mailer->send($message);

            return true;
        } catch (TransportExceptionInterface $e) {
            return $e->getMessage();
        }
    }
}

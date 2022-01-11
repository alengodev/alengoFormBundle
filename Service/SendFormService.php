<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class SendFormService implements SendFormInterface
{
    private MailerInterface $mailer;
    private string $defaultSenderName;
    private string $defaultSenderMail;

    public function __construct(MailerInterface $mailer, string $defaultSenderName = NULL, string $defaultSenderMail = NULL)
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
            ->subject($title)
            ->htmlTemplate($template)
            ->textTemplate($xmlTemplate)
            ->context([
                'formData' => $formData,
                'data' => $formData->getData(),
                'additionalData' => $additionalData
            ]);

        if(isset($files) && is_array($files)){
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
<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Swift_Mailer;
use Twig\Environment;


class SendFormService implements SendFormInterface
{

    private Environment $twig;
    private string $defaultSenderName;
    private Swift_Mailer $mailer;

    public function __construct(Swift_Mailer $mailer, Environment $twig, string $defaultSenderName = NULL)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->defaultSenderName = $defaultSenderName;
    }

    public function sendFormDataAsMail(FormData $formData, string $template, string $title, string $receiverMail, string $senderMail, $xmlTemplate = false)
    {
        $message = (new \Swift_Message($title))
            ->setFrom($senderMail, $this->defaultSenderName)
            ->setTo($receiverMail)
            ->setBody(
                $this->twig->render(
                    $template,
                    $formData->getData()
                ),
                'text/html'
            );

        if ($xmlTemplate) {
            $message->addPart($this->twig->render(
                $xmlTemplate,
                $formData->getData()
            ),
                'text/plain');
        }

        $this->mailer->send($message);
    }
}
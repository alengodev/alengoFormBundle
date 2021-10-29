<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Swift_Mailer;
use Twig\Environment;


class SendFormService implements SendFormInterface
{

    private Environment $twig;

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendFormDataAsMail(FormData $formData, string $template, string $title, string $receiverMail)
    {
        $message = (new \Swift_Message($title))
            ->setFrom($formData->getReceiverMail())
            ->setTo($receiverMail)
            ->setBody(
                $this->twig->render(
                    $template,
                    $formData->getData()
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sendFormDataAsXmlMail(FormData $formData, string $template, string $title, string $receiverMail): void
    {
        $message = (new \Swift_Message($title))
            ->setFrom($formData->getReceiverMail())
            ->setTo($receiverMail)
            ->setBody(
                $this->twig->render(
                    $template,
                    $formData->getData()
                ),
                'text/plain'
            );

        $this->mailer->send($message);
    }
}
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

    public function sendFormDataAsMail(FormData $formData, string $template, string $title)
    {
        $message = (new \Swift_Message($title))
            ->setFrom($formData->getReceiverMail())
            ->setBody(
                $this->twig->render(
                    $template,
                    $formData->getData()
                ),
                'text/html'
            );

        if (!$formData->isCopy()) {
            $message->setTo($formData->getReceiverMail());
        } else {
            $message->setTo([$formData->getReceiverMail(), $formData->getUserMail()]);
        }


        $this->mailer->send($message);
    }
}
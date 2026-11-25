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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendFormService implements SendFormInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly ?string $defaultSenderName = null,
        private readonly ?string $defaultSenderMail = null,
    ) {
    }

    public function sendFormDataAsMail(
        FormData $formData,
        string $template,
        string $title,
        string $receiverMail,
        ?string $xmlTemplate = null,
        ?array $files = null,
        ?array $additionalData = null,
    ): bool|string {
        $message = (new TemplatedEmail())
            ->from(new Address($this->defaultSenderMail ?? '', $this->defaultSenderName ?? ''))
            ->to(new Address($receiverMail))
            ->replyTo($formData->getData()['email'] ?? $this->defaultSenderMail ?? '')
            ->subject($title)
            ->htmlTemplate($template)
            ->context([
                'formData' => $formData,
                'data' => $formData->getData(),
                'additionalData' => $additionalData,
            ]);

        if (null !== $xmlTemplate) {
            $message->textTemplate($xmlTemplate);
        }

        if (null !== $files) {
            foreach ($files as $attachment) {
                $message->attachFromPath(self::localFile($attachment));
            }
        }

        try {
            $this->mailer->send($message);

            return true;
        } catch (TransportExceptionInterface $e) {
            return $e->getMessage();
        }
    }

    /**
     * Attachments are read on the server: only existing regular local files. A stream wrapper ("http://", "phar://",
     * "php://filter") would turn a path that reached the caller from outside into a server-side request or file read.
     */
    private static function localFile(mixed $path): string
    {
        if (!\is_string($path) || \str_contains($path, '://') || !\is_file($path)) {
            throw new \InvalidArgumentException(\sprintf('Attachment "%s" is not a local file.', \is_string($path) ? $path : \get_debug_type($path)));
        }

        return $path;
    }
}

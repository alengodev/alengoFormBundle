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

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Service\SendFormService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

#[CoversClass(SendFormService::class)]
final class SendFormServiceTest extends TestCase
{
    private string $file;

    protected function setUp(): void
    {
        $this->file = (string) \tempnam(\sys_get_temp_dir(), 'cv');
        \file_put_contents($this->file, '%PDF-1.7');
    }

    protected function tearDown(): void
    {
        @\unlink($this->file);
    }

    public function testLocalFilesAreAttached(): void
    {
        $sent = null;
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects(self::once())->method('send')->willReturnCallback(static function (RawMessage $message) use (&$sent): void {
            $sent = $message;
        });

        self::assertTrue($this->service($mailer)->sendFormDataAsMail($this->formData(), 'mail.html.twig', 'Subject', 'hr@example.com', files: [$this->file]));

        self::assertInstanceOf(TemplatedEmail::class, $sent);
        self::assertCount(1, $sent->getAttachments());
    }

    /**
     * Attachments are read from the server: a stream wrapper would fetch a URL (or run phar metadata), a missing or
     * non-regular file is a programming error. Never send such a mail.
     */
    #[DataProvider('invalidAttachments')]
    public function testOnlyLocalFilesCanBeAttached(string $path): void
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects(self::never())->method('send');

        $this->expectException(\InvalidArgumentException::class);

        $this->service($mailer)->sendFormDataAsMail($this->formData(), 'mail.html.twig', 'Subject', 'hr@example.com', files: [$path]);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function invalidAttachments(): iterable
    {
        yield 'http URL' => ['http://169.254.169.254/latest/meta-data'];
        yield 'phar wrapper' => ['phar:///tmp/upload.jpg/x'];
        yield 'php wrapper' => ['php://filter/resource=/etc/hosts'];
        yield 'missing file' => ['/nonexistent/cv.pdf'];
        yield 'directory' => [\sys_get_temp_dir()];
    }

    private function service(MailerInterface $mailer): SendFormService
    {
        return new SendFormService($mailer, 'Website', 'noreply@example.com');
    }

    private function formData(): FormData
    {
        $formData = new FormData();
        $formData->setData(['email' => 'applicant@example.com']);

        return $formData;
    }
}

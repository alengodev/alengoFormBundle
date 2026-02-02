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

namespace Alengo\Bundle\AlengoFormBundle\Entity;

use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormDataRepository::class)]
class FormData
{
    final public const RESOURCE_KEY = 'formData';
    final public const SECURITY_CONTEXT = 'sulu.form.datas';

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $locale = '';

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $webspaceKey = '';

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $copy = false;

    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $receiverMail = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $userMail = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $comments = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $changed = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $countedComments = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getWebspaceKey(): string
    {
        return $this->webspaceKey;
    }

    public function setWebspaceKey(string $webspaceKey): void
    {
        $this->webspaceKey = $webspaceKey;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    public function setCreated(?\DateTime $created): void
    {
        $this->created = $created;
    }

    public function getChanged(): ?\DateTime
    {
        return $this->changed;
    }

    public function setChanged(?\DateTime $changed): void
    {
        $this->changed = $changed;
    }

    public function getReceiverMail(): ?string
    {
        return $this->receiverMail;
    }

    public function setReceiverMail(?string $receiverMail): void
    {
        $this->receiverMail = $receiverMail;
    }

    public function getUserMail(): ?string
    {
        return $this->userMail;
    }

    public function setUserMail(?string $userMail): void
    {
        $this->userMail = $userMail;
    }

    public function getComments(): ?array
    {
        return $this->comments;
    }

    public function setComments(?array $comments): void
    {
        $this->comments = $comments;
    }

    public function getCountedComments(): int
    {
        return $this->countedComments;
    }

    public function setCountedComments(int $countedComments): void
    {
        $this->countedComments = $countedComments;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function isCopy(): bool
    {
        return $this->copy;
    }

    public function setCopy(bool $copy): void
    {
        $this->copy = $copy;
    }
}

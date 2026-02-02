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
    private $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $locale;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $webspaceKey;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $copy = false;

    #[ORM\Column(type: Types::JSON)]
    private $data;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private $receiverMail;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private $userMail;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private $category;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private $comments;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private $created;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private $changed;

    #[ORM\Column(type: Types::INTEGER)]
    private int $countedComments = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale(mixed $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getWebspaceKey()
    {
        return $this->webspaceKey;
    }

    public function setWebspaceKey(mixed $webspaceKey): void
    {
        $this->webspaceKey = $webspaceKey;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated(mixed $created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getChanged()
    {
        return $this->changed;
    }

    public function setChanged(mixed $changed): void
    {
        $this->changed = $changed;
    }

    /**
     * @return mixed
     */
    public function getReceiverMail()
    {
        return $this->receiverMail;
    }

    public function setReceiverMail(mixed $receiverMail): void
    {
        $this->receiverMail = $receiverMail;
    }

    /**
     * @return mixed
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    public function setUserMail(mixed $userMail): void
    {
        $this->userMail = $userMail;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function setComments(mixed $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getCountedComments()
    {
        return $this->countedComments;
    }

    public function setCountedComments(mixed $countedComments): void
    {
        $this->countedComments = $countedComments;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(mixed $category): void
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

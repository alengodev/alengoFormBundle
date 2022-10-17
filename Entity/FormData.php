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

namespace Alengo\Bundle\AlengoFormBundle\Entity;

use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormDataRepository::class)]
class FormData
{
    public const RESOURCE_KEY = 'formData';
    public const SECURITY_CONTEXT = 'sulu.form.datas';

    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $locale;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private $webspaceKey;

    #[ORM\Column(type: Types::BOOLEAN)]
    private $copy = false;

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
    private $countedComments = 0;

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

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
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

    /**
     * @param mixed $webspaceKey
     */
    public function setWebspaceKey($webspaceKey): void
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

    /**
     * @param mixed $data
     */
    public function setData($data): void
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

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
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

    /**
     * @param mixed $changed
     */
    public function setChanged($changed): void
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

    /**
     * @param mixed $receiverMail
     */
    public function setReceiverMail($receiverMail): void
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

    /**
     * @param mixed $userMail
     */
    public function setUserMail($userMail): void
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

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
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

    /**
     * @param mixed $countedComments
     */
    public function setCountedComments($countedComments): void
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

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
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

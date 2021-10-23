<?php

namespace Alengo\Bundle\AlengoFormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository")
 */
class FormData
{

    const RESOURCE_KEY = 'formData';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $webspaceKey;

    /**
     * @ORM\Column(type="json")
     */
    private $data;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $receiverMail;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $userMail;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $changed;

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

}
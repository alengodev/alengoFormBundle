<?php

namespace Alengo\Bundle\AlengoFormBundle\Api;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData as FormDataEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * The FormData class which will be exported to the API.
 *
 * @ExclusionPolicy("all")
 */
class FormData
{

    public function __construct(FormDataEntity $entity, $locale)
    {
        // @var FormDataEntity entity
        $this->entity = $entity;
        $this->locale = $locale;
    }

    /**
     * @VirtualProperty
     * @SerializedName("id")
     * @Groups({"fullFormData"})
     */
    public function getId(): ?int
    {
        return $this->entity->getId();
    }

    /**
     * @VirtualProperty
     * @SerializedName("created")
     * @Groups({"fullFormData"})
     */
    public function getCreated(): \DateTime
    {
        return $this->entity->getCreated();
    }

    /**
     * @VirtualProperty
     * @SerializedName("changed")
     * @Groups({"fullFormData"})
     */
    public function getChanged(): \DateTime
    {
        return $this->entity->getChanged();
    }

    /**
     * @VirtualProperty
     * @SerializedName("webspace")
     * @Groups({"fullFormData"})
     */
    public function getWebspace(): string
    {
        return $this->entity->getWebspaceKey();
    }

    /**
     * @VirtualProperty
     * @SerializedName("locale")
     * @Groups({"fullFormData"})
     */
    public function getLocale(): string
    {
        return $this->entity->getLocale();
    }

    /**
     * @VirtualProperty
     * @SerializedName("receiverMail")
     * @Groups({"fullFormData"})
     */
    public function getReceiverMail(): ?string
    {
        return $this->entity->getReceiverMail();
    }

    /**
     * @VirtualProperty
     * @SerializedName("userMail")
     * @Groups({"fullFormData"})
     */
    public function getUserMail(): ?string
    {
        return $this->entity->getUserMail();
    }

    /**
     * @VirtualProperty
     * @SerializedName("data")
     * @Groups({"fullFormData"})
     */
    public function getData(): array
    {
        $data = [];
        if (!$this->entity->getData()) {
            return $data;
        }
        foreach ($this->entity->getData() as $key => $dataElement) {
            $data[] = [
                'type' => 'field',
                'data' => $dataElement,
                'label' => $key
            ];
        }
        return $data;
    }

    /**
     * @VirtualProperty
     * @SerializedName("comments")
     * @Groups({"fullFormData"})
     */
    public function getComments(): array
    {
        if (!$this->entity->getComments()) {
            return [];
        }

        return $this->entity->getComments();
    }

    /**
     * @VirtualProperty
     * @SerializedName("countedComments")
     * @Groups({"fullFormData"})
     */
    public function getCountedComments(): int
    {
        return $this->entity->getCountedComments();
    }

    /**
     * @VirtualProperty
     * @SerializedName("category")
     * @Groups({"fullFormData"})
     */
    public function getCategory(): ?string
    {
        return $this->entity->getCategory();
    }
}
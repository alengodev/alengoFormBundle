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
     * @SerializedName("data")
     * @Groups({"fullFormData"})
     */
    public function getData(): array
    {
        if (!$this->entity->getData()) {
        return [];
        }

        return $this->entity->getData();
    }
}
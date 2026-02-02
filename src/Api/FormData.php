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

namespace Alengo\Bundle\AlengoFormBundle\Api;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData as FormDataEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * The FormData class which will be exported to the API.
 */
#[ExclusionPolicy('all')]
class FormData
{
    public function __construct(
        private readonly FormDataEntity $entity,
    ) {
    }

    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getId(): ?int
    {
        return $this->entity->getId();
    }

    #[SerializedName('created')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getCreated(): ?\DateTime
    {
        return $this->entity->getCreated();
    }

    #[SerializedName('changed')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getChanged(): ?\DateTime
    {
        return $this->entity->getChanged();
    }

    #[SerializedName('webspace')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getWebspace(): string
    {
        return $this->entity->getWebspaceKey();
    }

    #[SerializedName('locale')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getLocale(): string
    {
        return $this->entity->getLocale();
    }

    #[SerializedName('receiverMail')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getReceiverMail(): ?string
    {
        return $this->entity->getReceiverMail();
    }

    #[SerializedName('userMail')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getUserMail(): ?string
    {
        return $this->entity->getUserMail();
    }

    #[SerializedName('data')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getData(): array
    {
        $entityData = $this->entity->getData();
        if ([] === $entityData) {
            return [];
        }

        $data = [];
        foreach ($entityData as $key => $dataElement) {
            $data[$key] = [
                'type' => 'field',
                'data' => \is_array($dataElement) ? $this->getDataAsJsonElement($dataElement) : $dataElement,
                'label' => $key,
            ];
        }
        \ksort($data);

        return \array_values($data);
    }

    #[SerializedName('comments')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getComments(): array
    {
        return $this->entity->getComments() ?? [];
    }

    #[SerializedName('countedComments')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getCountedComments(): int
    {
        return $this->entity->getCountedComments();
    }

    #[SerializedName('category')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getCategory(): ?string
    {
        return $this->entity->getCategory();
    }

    #[SerializedName('copy')]
    #[VirtualProperty]
    #[Groups(['fullFormData'])]
    public function getCopy(): int
    {
        return $this->entity->isCopy() ? 1 : 0;
    }

    private function getDataAsJsonElement(array $dataElement): string
    {
        return (new JsonEncoder())->encode($dataElement, 'json');
    }
}

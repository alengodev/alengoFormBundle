<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;

class SaveFormService implements SaveFormInterface
{
    private FormDataRepository $repository;
    private FormDataFactory $factory;
    private string $defaultReceiverMail;

    public function __construct(
        FormDataRepository $repository,
        FormDataFactory    $factory,
        string             $defaultReceiverMail
    )
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->defaultReceiverMail = $defaultReceiverMail;
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function saveFormDataFromRequest(array $data, string $webspace, string $location, string $category,string $receiverMail = NULL, bool $copy = false): FormData
    {
        $formData = $this->factory->generateFormDataByData($data, $webspace, $location, $category,$receiverMail ?? $this->defaultReceiverMail,$copy);
        $this->repository->save($formData);
        return $formData;
    }

    public function updateFormData(FormData $formData, array $data): FormData
    {
        $formData = $this->factory->updateFormDataByData($formData, $data);
        $this->repository->save($formData);
        return $formData;
    }


}
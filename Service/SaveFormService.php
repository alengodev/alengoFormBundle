<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;

class SaveFormService implements SaveFormInterface
{
    private FormDataRepository $repository;
    private FormDataFactory $factory;

    public function __construct(
        FormDataRepository $repository,
        FormDataFactory $factory
    )
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function saveFormDataFromRequest(array $data, string $webspace, string $location): FormData
    {
        $formData = $this->factory->generateFormDataByData($data, $webspace, $location);
        $this->repository->save($formData);
        return $formData;
    }
}
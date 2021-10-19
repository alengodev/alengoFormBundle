<?php

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;

class SaveFormService implements SaveFormInterface
{
    private FormDataRepository $repository;

    public function __construct(FormDataRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function saveFormDataFromRequest(array $data): FormData
    {
        $formData = FormDataFactory::generateFormDataByData($data,'','');
        $this->repository->save($formData);
        return $formData;
    }
}
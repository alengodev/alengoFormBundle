<?php

declare(strict_types=1);

namespace Alengo\Bundle\AlengoFormBundle\Service;

use Alengo\Bundle\AlengoFormBundle\Repository\FormDataRepository;

class FormDataService implements FormDataInterface
{
    public function __construct(
        private readonly FormDataRepository $formDataRepository,
    ) {
    }

    public function listFormDataFromRequest(string $datefrom, string $dateto, string $locale, string $category, string $webspaceKey, string $receiverMail, string $userMail): array
    {
        $data = $this->formDataRepository->listFormData($datefrom, $dateto, $locale, $category, $webspaceKey, $receiverMail, $userMail);

        $formData = [];
        foreach ($data as $key => $item) {
            $formData[$key]['id'] = $item->getId();
            $formData[$key]['locale'] = $item->getLocale();
            $formData[$key]['webspaceKey'] = $item->getWebspaceKey();
            $formData[$key]['data'] = $item->getData();
            $formData[$key]['receiverMail'] = $item->getReceiverMail();
            $formData[$key]['userMail'] = $item->getUserMail();
            $formData[$key]['category'] = $item->getCategory();
            $formData[$key]['comments'] = $item->getComments();
            $formData[$key]['datefrom'] = $item->getCreated()->format('Y-m-d');
            $formData[$key]['dateto'] = $item->getCreated()->format('Y-m-d');
            $formData[$key]['created'] = $item->getCreated();
            $formData[$key]['changed'] = $item->getChanged();
        }

        return [
            'count' => \count($formData),
            'data' => $formData,
        ];
    }
}

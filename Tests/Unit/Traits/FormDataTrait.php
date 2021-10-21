<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Traits;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;

trait FormDataTrait
{

    public function generateFormData(): FormData
    {
        $data = new FormData();
        $data->setWebspaceKey('alengo');
        $data->setData(['firstname' => 'Oliver']);
        $data->setUserMail('usertest@test.de');
        $data->setReceiverMail('receivertest@test.de');
        $data->setLocale('de');
        $data->setCreated(new \DateTime());
        $data->setChanged(new \DateTime());

        return $data;
    }
}
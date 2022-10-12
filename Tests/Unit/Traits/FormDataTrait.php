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

    public function generateFormDataWithArray(): FormData
    {
        $data = new FormData();
        $data->setWebspaceKey('alengo');
        $data->setData(['firstname' => 'Oliver', 'arrayData' => ['1' => 'test']]);
        $data->setUserMail('usertest@test.de');
        $data->setReceiverMail('receivertest@test.de');
        $data->setLocale('de');
        $data->setCreated(new \DateTime());
        $data->setChanged(new \DateTime());

        return $data;
    }
}

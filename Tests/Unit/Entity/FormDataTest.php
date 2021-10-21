<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use PHPUnit\Framework\TestCase;

class FormDataTest extends TestCase
{
    public function testFactory()
    {
        $data = new FormData();
        $data->setWebspaceKey('alengo');
        $data->setData(['firstname' => 'Oliver']);
        $data->setUserMail('usertest@test.de');
        $data->setReceiverMail('receivertest@test.de');
        $data->setLocale('de');
        $data->setCreated(new \DateTime());
        $data->setChanged(new \DateTime());

        self::assertSame($data->getData(), ['firstname' => 'Oliver']);
        self::assertSame($data->getUserMail(), 'usertest@test.de');
        self::assertSame($data->getReceiverMail(), 'receivertest@test.de');
        self::assertSame($data->getLocale(), 'de');
        self::assertSame($data->getWebspaceKey(), 'alengo');
    }
}
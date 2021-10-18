<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use PHPUnit\Framework\TestCase;

class FormDataTest extends TestCase
{
    public function testFactory()
    {
        $data = new FormData();
        $data->setWebspaceKey('alengo');
        $data->setData(['firstname' => 'Oliver']);
        $data->setLocale('de');
        $data->setCreated(new \DateTime());
        $data->setChanged(new \DateTime());

        self::assertSame($data->getData(),['firstname' => 'Oliver']);
        self::assertSame($data->getLocale(),'de');
        self::assertSame($data->getWebspaceKey(),'alengo');
    }
}
<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use PHPUnit\Framework\TestCase;

class FormDataFactoryTest extends TestCase
{
    public function testFactory()
    {
        $data = FormDataFactory::generateFormDataByData(['username' => 'Oliver'],'alengo','de');
        self::assertSame($data->getData(),['username' => 'Oliver']);
        self::assertSame($data->getLocale(),'de');
        self::assertSame($data->getWebspaceKey(),'alengo');
    }
}
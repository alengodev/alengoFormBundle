<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use PHPUnit\Framework\TestCase;

class FormDataFactoryTest extends TestCase
{
    public function testFactory()
    {
        $factory = new FormDataFactory();
        $data = $factory->generateFormDataByData(['username' => 'Oliver', 'email' => 'userMail@test.de'], 'alengo', 'de', 'test@test.de');
        self::assertSame($data->getData(), ['username' => 'Oliver', 'email' => 'userMail@test.de']);
        self::assertSame($data->getLocale(), 'de');
        self::assertSame($data->getWebspaceKey(), 'alengo');
        self::assertSame($data->getUserMail(), 'userMail@test.de');
        self::assertSame($data->getReceiverMail(), 'test@test.de');
    }
}
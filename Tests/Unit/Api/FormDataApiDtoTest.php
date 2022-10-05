<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Api;

use Alengo\Bundle\AlengoFormBundle\Api\FormData;
use Alengo\Bundle\AlengoFormBundle\Tests\Unit\Traits\FormDataTrait;
use PHPUnit\Framework\TestCase;

class FormDataApiDtoTest extends TestCase
{

    use FormDataTrait;

    public function testApiDto()
    {
        $apiDto = new FormData($this->generateFormData(), 'en');

        self::assertSame($apiDto->getData(), [['type' => 'field','data' => 'Oliver', 'label' => 'firstname']]);
        self::assertSame($apiDto->getUserMail(), 'usertest@test.de');
        self::assertSame($apiDto->getReceiverMail(), 'receivertest@test.de');
        self::assertSame($apiDto->getLocale(), 'de');
        self::assertSame($apiDto->getWebspace(), 'alengo');
    }

    public function testApiDtoWithArray()
    {
        $apiDto = new FormData($this->generateFormDataWithArray(), 'en');

        self::assertSame($apiDto->getData(), [['type' => 'field','data' => '{"1":"test"}', 'label' => 'arrayData'],['type' => 'field','data' => 'Oliver', 'label' => 'firstname']]);
        self::assertSame($apiDto->getUserMail(), 'usertest@test.de');
        self::assertSame($apiDto->getReceiverMail(), 'receivertest@test.de');
        self::assertSame($apiDto->getLocale(), 'de');
        self::assertSame($apiDto->getWebspace(), 'alengo');
    }

}
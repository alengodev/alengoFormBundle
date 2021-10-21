<?php

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity;

use Alengo\Bundle\AlengoFormBundle\Tests\Unit\Traits\FormDataTrait;
use PHPUnit\Framework\TestCase;

class FormDataTest extends TestCase
{
    use FormDataTrait;

    public function testFactory()
    {
        $data = $this->generateFormData();

        self::assertSame($data->getData(), ['firstname' => 'Oliver']);
        self::assertSame($data->getUserMail(), 'usertest@test.de');
        self::assertSame($data->getReceiverMail(), 'receivertest@test.de');
        self::assertSame($data->getLocale(), 'de');
        self::assertSame($data->getWebspaceKey(), 'alengo');
    }
}
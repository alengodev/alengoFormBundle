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

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Api;

use Alengo\Bundle\AlengoFormBundle\Api\FormData;
use Alengo\Bundle\AlengoFormBundle\Tests\Unit\Traits\FormDataTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class FormDataApiDtoTest extends TestCase
{
    use FormDataTrait;

    public function testApiDto(): void
    {
        $apiDto = new FormData($this->generateFormData(), 'en');

        static::assertSame($apiDto->getData(), [['type' => 'field', 'data' => 'Oliver', 'label' => 'firstname']]);
        static::assertSame($apiDto->getUserMail(), 'usertest@test.de');
        static::assertSame($apiDto->getReceiverMail(), 'receivertest@test.de');
        static::assertSame($apiDto->getLocale(), 'de');
        static::assertSame($apiDto->getWebspace(), 'alengo');
    }

    public function testApiDtoWithArray(): void
    {
        $apiDto = new FormData($this->generateFormDataWithArray(), 'en');

        static::assertSame($apiDto->getData(), [['type' => 'field', 'data' => '{"1":"test"}', 'label' => 'arrayData'], ['type' => 'field', 'data' => 'Oliver', 'label' => 'firstname']]);
        static::assertSame($apiDto->getUserMail(), 'usertest@test.de');
        static::assertSame($apiDto->getReceiverMail(), 'receivertest@test.de');
        static::assertSame($apiDto->getLocale(), 'de');
        static::assertSame($apiDto->getWebspace(), 'alengo');
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity\Factory;

use Alengo\Bundle\AlengoFormBundle\Entity\Factory\FormDataFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class FormDataFactoryTest extends TestCase
{
    public function testFactory(): void
    {
        $factory = new FormDataFactory();
        $data = $factory->generateFormDataByData(['username' => 'Oliver', 'email' => 'userMail@test.de'], 'alengo', 'de', 'test category', 'test@test.de');
        static::assertSame($data->getData(), ['username' => 'Oliver', 'email' => 'userMail@test.de']);
        static::assertSame($data->getLocale(), 'de');
        static::assertSame($data->getWebspaceKey(), 'alengo');
        static::assertSame($data->getUserMail(), 'userMail@test.de');
        static::assertSame($data->getReceiverMail(), 'test@test.de');
    }
}

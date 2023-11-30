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

namespace Alengo\Bundle\AlengoFormBundle\Tests\Unit\Entity;

use Alengo\Bundle\AlengoFormBundle\Tests\Unit\Traits\FormDataTrait;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class FormDataTest extends TestCase
{
    use FormDataTrait;

    public function testFactory(): void
    {
        $data = $this->generateFormData();

        static::assertSame($data->getData(), ['firstname' => 'Oliver']);
        static::assertSame($data->getUserMail(), 'usertest@test.de');
        static::assertSame($data->getReceiverMail(), 'receivertest@test.de');
        static::assertSame($data->getLocale(), 'de');
        static::assertSame($data->getWebspaceKey(), 'alengo');
    }
}

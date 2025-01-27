<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Respect\Validation\Test\RuleTestCase;

use function random_int;
use function tmpfile;

use const PHP_INT_MAX;

#[Group('rule')]
#[CoversClass(MacAddress::class)]
final class MacAddressTest extends RuleTestCase
{
    /**
     * @return array<array{MacAddress, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $sut = new MacAddress();

        return [
            [$sut, '00:11:22:33:44:55'],
            [$sut, '66-77-88-99-aa-bb'],
            [$sut, 'AF:0F:bd:12:44:ba'],
            [$sut, '90-bc-d3-1a-dd-cc'],
        ];
    }

    /**
     * @return array<array{MacAddress, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $sut = new MacAddress();

        return [
            'empty string' => [$sut, ''],
            'invalid MAC address' => [$sut, '00-1122:33:44:55'],
            'boolean' => [$sut, true],
            'array' => [$sut, ['90-bc-d3-1a-dd-cc']],
            'int' => [$sut, random_int(1, PHP_INT_MAX)],
            'float' => [$sut, random_int(1, 9) / 10],
            'null' => [$sut, null],
            'resource' => [$sut, tmpfile()],
            'callable' => [
                $sut,
                static function (): void {
                },
            ],
        ];
    }
}

<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Respect\Validation\Test\RuleTestCase;
use stdClass;

use function date;
use function strtotime;

#[Group('rule')]
#[CoversClass(AbstractAge::class)]
#[CoversClass(MaxAge::class)]
final class MaxAgeTest extends RuleTestCase
{
    /**
     * @return array<array{MaxAge, mixed}>
     */
    public static function providerForValidInput(): array
    {
        return [
            [new MaxAge(30, 'Y-m-d'), date('Y-m-d', strtotime('30 years ago'))],
            [new MaxAge(30, 'Y-m-d'), date('Y-m-d', strtotime('29 years ago'))],
            [new MaxAge(30), '30 years ago'],
            [new MaxAge(30), '29 years ago'],
        ];
    }

    /**
     * @return array<array{MaxAge, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        return [
            [new MaxAge(30), new DateTime('30 years ago')],
            [new MaxAge(30), new DateTime('29 years ago')],
            [new MaxAge(30), new DateTimeImmutable('30 years ago')],
            [new MaxAge(30), new DateTimeImmutable('29 years ago')],
            [new MaxAge(30, 'Y-m-d'), new DateTime('30 years ago')],
            [new MaxAge(30, 'Y-m-d'), new DateTimeImmutable('30 years ago')],
            [new MaxAge(30, 'Y-m-d'), '30 years ago'],
            [new MaxAge(30, 'Y-m-d'), date('Y/m/d', strtotime('30 years ago'))],
            [new MaxAge(30), new DateTime('31 years ago')],
            [new MaxAge(30), new DateTimeImmutable('31 years ago')],
            [new MaxAge(30), '31 years ago'],
            [new MaxAge(30, 'Y-m-d'), date('Y-m-d', strtotime('31 years ago'))],
            [new MaxAge(30), 'invalid-input'],
            [new MaxAge(30), new stdClass()],
        ];
    }
}

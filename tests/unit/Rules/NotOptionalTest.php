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
use stdClass;

#[Group('rule')]
#[CoversClass(NotOptional::class)]
final class NotOptionalTest extends RuleTestCase
{
    /**
     * @return array<array{NotOptional, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $rule = new NotOptional();

        return [
            [$rule, []],
            [$rule, ' '],
            [$rule, 0],
            [$rule, '0'],
            [$rule, 0],
            [$rule, '0.0'],
            [$rule, false],
            [$rule, ['']],
            [$rule, [' ']],
            [$rule, [0]],
            [$rule, ['0']],
            [$rule, [false]],
            [$rule, [[''], [0]]],
            [$rule, new stdClass()],
        ];
    }

    /**
     * @return array<array{NotOptional, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $rule = new NotOptional();

        return [
            [$rule, null],
            [$rule, ''],
        ];
    }
}

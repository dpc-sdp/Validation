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
#[CoversClass(StringType::class)]
final class StringTypeTest extends RuleTestCase
{
    /**
     * @return array<array{StringType, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $rule = new StringType();

        return [
            [$rule, ''],
            [$rule, '165.7'],
        ];
    }

    /**
     * @return array<array{StringType, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $rule = new StringType();

        return [
            [$rule, null],
            [$rule, []],
            [$rule, new stdClass()],
            [$rule, 150],
        ];
    }
}

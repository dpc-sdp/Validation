<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use ArrayIterator;
use ArrayObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Respect\Validation\Test\RuleTestCase;

#[Group(' rule')]
#[CoversClass(ArrayType::class)]
final class ArrayTypeTest extends RuleTestCase
{
    /**
     * @return array<array{ArrayType, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $rule = new ArrayType();

        return [
            [$rule, []],
            [$rule, [1, 2, 3]],
        ];
    }

    /**
     * @return array<array{ArrayType, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $rule = new ArrayType();

        return [
            [$rule, 'test'],
            [$rule, 1],
            [$rule, 1.0],
            [$rule, true],
            [$rule, new ArrayObject()],
            [$rule, new ArrayIterator()],
        ];
    }
}

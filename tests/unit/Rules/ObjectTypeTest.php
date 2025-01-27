<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use ArrayObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Respect\Validation\Test\RuleTestCase;
use stdClass;

#[Group('rule')]
#[CoversClass(ObjectType::class)]
final class ObjectTypeTest extends RuleTestCase
{
    /**
     * @return array<array{ObjectType, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $rule = new ObjectType();

        return [
            [$rule, new stdClass()],
            [$rule, new ArrayObject()],
        ];
    }

    /**
     * @return array<array{ObjectType, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $rule = new ObjectType();

        return [
            [$rule, ''],
            [$rule, null],
            [$rule, 121],
            [$rule, []],
            [$rule, 'Foo'],
            [$rule, false],
        ];
    }
}

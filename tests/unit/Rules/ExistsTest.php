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
use SplFileInfo;
use SplFileObject;

#[Group('rule')]
#[CoversClass(Exists::class)]
final class ExistsTest extends RuleTestCase
{
    /**
     * @return array<array{Exists, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $rule = new Exists();

        return [
            [$rule, __FILE__],
            [$rule, new SplFileInfo(__FILE__)],
            [$rule, new SplFileObject(__FILE__)],
        ];
    }

    /**
     * @return array<array{Exists, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $rule = new Exists();

        return [
            [$rule, 'path/of/a/non-existent/file'],
            [$rule, new SplFileInfo('path/of/a/non-existent/file')],
        ];
    }
}

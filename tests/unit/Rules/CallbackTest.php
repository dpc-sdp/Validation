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
#[CoversClass(Callback::class)]
final class CallbackTest extends RuleTestCase
{
    /**
     * @return array<array{Callback, mixed}>
     */
    public static function providerForValidInput(): array
    {
        return [
            [new Callback('is_a', 'stdClass'), new stdClass()],
            [new Callback([new AlwaysValid(), 'validate']), 'test'],
            [new Callback('is_string'), 'test'],
            [
                new Callback(static function () {
                    return true;
                }),
                'wpoiur',
            ],
        ];
    }

    /**
     * @return array<array{Callback, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        return [
            [
                new Callback(static function () {
                    return false;
                }),
                'w poiur',
            ],
            [
                new Callback(static function () {
                    return false;
                }),
                '',
            ],
        ];
    }
}

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
#[CoversClass(AbstractFilterRule::class)]
#[CoversClass(Alnum::class)]
final class AlnumTest extends RuleTestCase
{
    /**
     * @return array<array{Alnum, mixed}>
     */
    public static function providerForValidInput(): array
    {
        return [
            [new Alnum(), 'alganet'],
            [new Alnum('- ! :'), 'foo :- 123 !'],
            [new Alnum('0-9'), '0alg-anet0'],
            [new Alnum(), '1'],
            [new Alnum(), 'a'],
            [new Alnum(), 'foobar'],
            [new Alnum('_'), 'rubinho_'],
            [new Alnum('.'), 'google.com'],
            [new Alnum(' '), 'alganet alganet'],
            [new Alnum(), 0],
            [new Alnum('!@#$%^&*(){}'), '!@#$%^&*(){}abc123'],
            [new Alnum('[]?+=/\\-_|"\',<>.'), '[]?+=/\\-_|"\',<>.abc123'],
            [new Alnum("[]?+=/\\-_|\"',<>. \t\n"), "abc[]?+=/\\-_|\"',<>. \t\n123"],
            [new Alnum('-', '*'), 'a-1*d'],
        ];
    }

    /**
     * @return array<array{Alnum, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        return [
            [new Alnum(), ''],
            [new Alnum(), 'number 100%'],
            [new Alnum('%'), 'number 100%'],
            [new Alnum(), '@#$'],
            [new Alnum(), '_'],
            [new Alnum(), 'dgç'],
            [new Alnum(), 1e21],
            [new Alnum(), null],
            [new Alnum(), new stdClass()],
            [new Alnum(), []],
            [new Alnum('%'), 'number 100%'],
            [new Alnum(), "\t"],
            [new Alnum(), "\n"],
            [new Alnum(), "\nabc"],
            [new Alnum(), "\tdef"],
            [new Alnum(), "\nabc \t"],
            [new Alnum(), 'alganet alganet'],
        ];
    }
}

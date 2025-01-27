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
use Respect\Validation\Test\Stubs\WithProperties;
use Respect\Validation\Test\Stubs\WithUninitialized;

#[Group('rule')]
#[CoversClass(AbstractRelated::class)]
#[CoversClass(Property::class)]
final class PropertyTest extends RuleTestCase
{
    /**
     * @return array<string, array{Property, mixed}>
     */
    public static function providerForValidInput(): array
    {
        return [
            'attribute is present without extra validator' => [new Property('public'), new WithProperties()],
            'private attribute is present without extra validator' => [
                new Property('private'),
                new WithProperties(),
            ],
            'attribute is present with extra validator' => [
                new Property('public', new AlwaysValid()),
                new WithProperties(),
            ],
            'attribute is present but uninitialized' => [
                new Property('uninitialized'),
                new WithUninitialized(),
            ],
            'non mandatory attribute is not present' => [
                new Property('nonexistent', null, false),
                new WithProperties(),
            ],
            'non mandatory attribute is not present with extra validator' => [
                new Property('nonexistent', new AlwaysValid(), false),
                new WithProperties(),
            ],
            'attribute is present but uninitialized with extra validator' => [
                new Property('uninitialized', new AlwaysValid()),
                new WithUninitialized(),
            ],
        ];
    }

    /**
     * @return array<string, array{Property, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        return [
            'attribute is absent without extra validator' => [new Property('barr'), new WithProperties()],
            'private attribute is not valid based on extra validator' => [
                new Property('private', new AlwaysInvalid()),
                new WithProperties(),
            ],
            'value provided is an empty string' => [new Property('barr'), ''],
            'validator related to attribute does not validate' => [
                new Property('public', new AlwaysInvalid()),
                new WithProperties(),
            ],
        ];
    }
}

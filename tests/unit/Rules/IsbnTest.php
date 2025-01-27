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

#[Group('rule')]
#[CoversClass(Isbn::class)]
final class IsbnTest extends RuleTestCase
{
    /**
     * @return array<array{Isbn, mixed}>
     */
    public static function providerForValidInput(): array
    {
        $sut = new Isbn();

        return [
            [$sut, 'ISBN-13: 978-0-596-52068-7'],
            [$sut, '978 0 596 52068 7'],
            [$sut, '9780596520687'],
            [$sut, '0-596-52068-9'],
            [$sut, '0 512 52068 9'],
            [$sut, 'ISBN-10 0-596-52068-9'],
            [$sut, 'ISBN-10: 0-596-52068-9'],
        ];
    }

    /**
     * @return array<array{Isbn, mixed}>
     */
    public static function providerForInvalidInput(): array
    {
        $sut = new Isbn();

        return [
            [$sut, 'ISBN 11978-0-596-52068-7'],
            [$sut, 'ISBN-12: 978-0-596-52068-7'],
            [$sut, '978 10 596 52068 7'],
            [$sut, '119780596520687'],
            [$sut, '0-5961-52068-9'],
            [$sut, '11 5122 52068 9'],
            [$sut, 'ISBN-11 0-596-52068-9'],
            [$sut, 'ISBN-10- 0-596-52068-9'],
            [$sut, 'Defiatly no ISBN'],
            [$sut, 'Neither ISBN-13: 978-0-596-52068-7'],
        ];
    }
}

<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;

use function preg_match;

#[Template(
    '{{name}} must contain only vowels',
    '{{name}} must not contain vowels',
    self::TEMPLATE_STANDARD,
)]
#[Template(
    '{{name}} must contain only vowels and {{additionalChars}}',
    '{{name}} must not contain vowels or {{additionalChars}}',
    self::TEMPLATE_EXTRA,
)]
final class Vowel extends AbstractFilterRule
{
    protected function validateFilteredInput(string $input): bool
    {
        return preg_match('/^[aeiouAEIOU]+$/', $input) > 0;
    }
}

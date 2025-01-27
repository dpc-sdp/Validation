<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;

use function is_string;

#[Template(
    '{{name}} must be of type string',
    '{{name}} must not be of type string',
)]
final class StringType extends AbstractRule
{
    public function validate(mixed $input): bool
    {
        return is_string($input);
    }
}

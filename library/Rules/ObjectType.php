<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;

use function is_object;

#[Template(
    '{{name}} must be of type object',
    '{{name}} must not be of type object',
)]
final class ObjectType extends AbstractRule
{
    public function validate(mixed $input): bool
    {
        return is_object($input);
    }
}

<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;

#[Template(
    '{{name}} must be multiple of {{multipleOf}}',
    '{{name}} must not be multiple of {{multipleOf}}',
)]
final class Multiple extends AbstractRule
{
    public function __construct(
        private readonly int $multipleOf
    ) {
    }

    public function validate(mixed $input): bool
    {
        if ($this->multipleOf == 0) {
            return $input == 0;
        }

        return $input % $this->multipleOf == 0;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return ['multipleOf' => $this->multipleOf];
    }
}

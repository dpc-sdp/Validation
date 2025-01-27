<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;

use function in_array;
use function is_array;
use function is_scalar;
use function mb_stripos;
use function mb_strpos;

#[Template(
    '{{name}} must contain the value {{containsValue}}',
    '{{name}} must not contain the value {{containsValue}}',
)]
final class Contains extends AbstractRule
{
    public function __construct(
        private readonly mixed $containsValue,
        private readonly bool $identical = false
    ) {
    }

    public function validate(mixed $input): bool
    {
        if (is_array($input)) {
            return in_array($this->containsValue, $input, $this->identical);
        }

        if (!is_scalar($input) || !is_scalar($this->containsValue)) {
            return false;
        }

        return $this->validateString((string) $input, (string) $this->containsValue);
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return ['containsValue' => $this->containsValue];
    }

    private function validateString(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return false;
        }

        if ($this->identical) {
            return mb_strpos($haystack, $needle) !== false;
        }

        return mb_stripos($haystack, $needle) !== false;
    }
}

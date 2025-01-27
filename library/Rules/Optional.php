<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;
use Respect\Validation\Helpers\CanValidateUndefined;

#[Template(
    'The value must be optional',
    'The value must not be optional',
    self::TEMPLATE_STANDARD,
)]
#[Template(
    '{{name}} must be optional',
    '{{name}} must not be optional',
    self::TEMPLATE_NAMED,
)]
final class Optional extends AbstractWrapper
{
    use CanValidateUndefined;

    public const TEMPLATE_NAMED = 'named';

    public function assert(mixed $input): void
    {
        if ($this->isUndefined($input)) {
            return;
        }

        parent::assert($input);
    }

    public function check(mixed $input): void
    {
        if ($this->isUndefined($input)) {
            return;
        }

        parent::check($input);
    }

    public function validate(mixed $input): bool
    {
        if ($this->isUndefined($input)) {
            return true;
        }

        return parent::validate($input);
    }

    public function getTemplate(mixed $input): string
    {
        if ($this->template !== null) {
            return $this->template;
        }

        if ($this->getName()) {
            return self::TEMPLATE_NAMED;
        }

        return self::TEMPLATE_STANDARD;
    }
}

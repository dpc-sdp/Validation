<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\ExceptionClass;
use Respect\Validation\Attributes\Template;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Exceptions\ValidationException;

use function count;

#[ExceptionClass(NestedValidationException::class)]
#[Template(
    'At least one of these rules must pass for {{name}}',
    'At least one of these rules must not pass for {{name}}',
)]
final class AnyOf extends AbstractComposite
{
    public function assert(mixed $input): void
    {
        try {
            parent::assert($input);
        } catch (NestedValidationException $exception) {
            if (count($exception->getChildren()) === count($this->getRules())) {
                throw $exception;
            }
        }
    }

    public function validate(mixed $input): bool
    {
        foreach ($this->getRules() as $v) {
            if ($v->validate($input)) {
                return true;
            }
        }

        return false;
    }

    public function check(mixed $input): void
    {
        foreach ($this->getRules() as $v) {
            try {
                $v->check($input);

                return;
            } catch (ValidationException $e) {
                if (!isset($firstException)) {
                    $firstException = $e;
                }
            }
        }

        if (isset($firstException)) {
            throw $firstException;
        }

        throw $this->reportError($input);
    }
}

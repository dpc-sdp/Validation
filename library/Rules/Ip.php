<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Attributes\Template;
use Respect\Validation\Exceptions\ComponentException;

use function bccomp;
use function explode;
use function filter_var;
use function ip2long;
use function is_string;
use function long2ip;
use function mb_strpos;
use function mb_substr_count;
use function sprintf;
use function str_repeat;
use function str_replace;
use function strtr;

use const FILTER_VALIDATE_IP;

#[Template(
    '{{name}} must be an IP address',
    '{{name}} must not be an IP address',
    self::TEMPLATE_STANDARD,
)]
#[Template(
    '{{name}} must be an IP address in the {{range}} range',
    '{{name}} must not be an IP address in the {{range}} range',
    self::TEMPLATE_NETWORK_RANGE,
)]
final class Ip extends AbstractRule
{
    public const TEMPLATE_NETWORK_RANGE = 'network_range';

    private ?string $range = null;

    private ?string $startAddress = null;

    private ?string $endAddress = null;

    private ?string $mask = null;

    public function __construct(string $range = '*', private ?int $options = null)
    {
        $this->parseRange($range);
        $this->range = $this->createRange();
    }

    public function validate(mixed $input): bool
    {
        if (!is_string($input)) {
            return false;
        }

        if (!$this->verifyAddress($input)) {
            return false;
        }

        if ($this->mask) {
            return $this->belongsToSubnet($input);
        }

        if ($this->startAddress && $this->endAddress) {
            return $this->verifyNetwork($input);
        }

        return true;
    }

    public function getTemplate(mixed $input): string
    {
        return $this->template ?? ($this->range ? self::TEMPLATE_NETWORK_RANGE : self::TEMPLATE_STANDARD);
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return ['range' => $this->range];
    }

    private function createRange(): ?string
    {
        if ($this->startAddress && $this->endAddress) {
            return $this->startAddress . '-' . $this->endAddress;
        }

        if ($this->startAddress && $this->mask) {
            return $this->startAddress . '/' . long2ip((int) $this->mask);
        }

        return null;
    }

    private function parseRange(string $input): void
    {
        if ($input == '*' || $input == '*.*.*.*' || $input == '0.0.0.0-255.255.255.255') {
            return;
        }

        if (mb_strpos($input, '-') !== false) {
            [$this->startAddress, $this->endAddress] = explode('-', $input);

            if ($this->startAddress !== null && !$this->verifyAddress($this->startAddress)) {
                throw new ComponentException('Invalid network range');
            }

            if ($this->endAddress !== null && !$this->verifyAddress($this->endAddress)) {
                throw new ComponentException('Invalid network range');
            }

            return;
        }

        if (mb_strpos($input, '*') !== false) {
            $this->parseRangeUsingWildcards($input);

            return;
        }

        if (mb_strpos($input, '/') !== false) {
            $this->parseRangeUsingCidr($input);

            return;
        }

        throw new ComponentException('Invalid network range');
    }

    private function fillAddress(string $address, string $fill = '*'): string
    {
        return $address . str_repeat('.' . $fill, 3 - mb_substr_count($address, '.'));
    }

    private function parseRangeUsingWildcards(string $input): void
    {
        $address = $this->fillAddress($input);

        $this->startAddress = strtr($address, '*', '0');
        $this->endAddress = str_replace('*', '255', $address);
    }

    private function parseRangeUsingCidr(string $input): void
    {
        $parts = explode('/', $input);

        $this->startAddress = $this->fillAddress($parts[0], '0');
        $isAddressMask = mb_strpos($parts[1], '.') !== false;

        if ($isAddressMask && $this->verifyAddress($parts[1])) {
            $this->mask = sprintf('%032b', ip2long($parts[1]));

            return;
        }

        if ($isAddressMask || $parts[1] < 8 || $parts[1] > 30) {
            throw new ComponentException('Invalid network mask');
        }

        $this->mask = sprintf('%032b', ip2long((string) long2ip(~(2 ** (32 - (int) $parts[1]) - 1))));
    }

    private function verifyAddress(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP, ['flags' => $this->options]) !== false;
    }

    private function verifyNetwork(string $input): bool
    {
        $input = sprintf('%u', ip2long($input));

        return $this->startAddress !== null
            && $this->endAddress !== null
            && bccomp($input, sprintf('%u', ip2long($this->startAddress))) >= 0
            && bccomp($input, sprintf('%u', ip2long($this->endAddress))) <= 0;
    }

    private function belongsToSubnet(string $input): bool
    {
        if ($this->mask === null || $this->startAddress === null) {
            return false;
        }

        $min = sprintf('%032b', ip2long($this->startAddress));
        $input = sprintf('%032b', ip2long($input));

        return ($input & $this->mask) === ($min & $this->mask);
    }
}

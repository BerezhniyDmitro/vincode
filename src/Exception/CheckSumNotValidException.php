<?php

declare(strict_types=1);

namespace CheckvinVincode\Exception;

use InvalidArgumentException;

class CheckSumNotValidException extends InvalidArgumentException
{
    private const EXCEPTION_CODE = 103;

    private function __construct(string $vin)
    {
        $message = 'Vincode Invalid. Checksum failed verification, check vincode please! ' . $vin;
        parent::__construct($message, self::EXCEPTION_CODE);
    }

    public static function create(string $vin): self
    {
        return new self($vin);
    }
}

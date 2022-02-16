<?php

declare(strict_types=1);

namespace CheckvinVincode\Exception;

use InvalidArgumentException;

class LengthNotValidException extends InvalidArgumentException
{
    private const EXCEPTION_CODE = 102;

    private function __construct(int $countChar)
    {
        $message = sprintf('VinCodeInvalid length mast be 17 characters. You - %s', $countChar);
        parent::__construct($message, self::EXCEPTION_CODE);
    }

    public static function create(int $countChar): self
    {
        return new self($countChar);
    }
}

<?php

declare(strict_types=1);

namespace CheckvinVincode\Exception;

use InvalidArgumentException;

class NotValidLetterException extends InvalidArgumentException
{
    private const EXCEPTION_CODE = 101;

    private function __construct(string $char, string $vinCode)
    {
        $message = sprintf(
            'Vincode Invalid. It must not contain the letters O (o), I (i) and Q (q). 
                    Use 0, 1, and 9. Invalid character %s. Vin - %s',
            $char,
            $vinCode
        );
        parent::__construct($message, self::EXCEPTION_CODE);
    }

    public static function create(string $char, string $vinCode): self
    {
        return new self($char, $vinCode);
    }
}

<?php

declare(strict_types=1);

namespace CheckvinVincode;

use CheckvinVincode\Exception\CheckSumNotValidException;
use CheckvinVincode\Exception\LengthNotValidException;
use CheckvinVincode\Exception\NotValidLetterException;
use InvalidArgumentException;

final class VinCode
{
    /**
     * @var string[]
     */
    private $availableChar = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'j',
        'k',
        'l',
        'm',
        'n',
        'p',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
    ];

    /**
     * @var int[]
     */
    private $weights = [8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2];

    /**
     * @var int[]
     */
    private $transliterations = [
        "a" => 1,
        "b" => 2,
        "c" => 3,
        "d" => 4,
        "e" => 5,
        "f" => 6,
        "g" => 7,
        "h" => 8,
        "j" => 1,
        "k" => 2,
        "l" => 3,
        "m" => 4,
        "n" => 5,
        "p" => 7,
        "r" => 9,
        "s" => 2,
        "t" => 3,
        "u" => 4,
        "v" => 5,
        "w" => 6,
        "x" => 7,
        "y" => 8,
        "z" => 9,
    ];

    /**
     * @var string $code
     */
    private $code;

    /**
     * VinCode constructor.
     * @param string $code Code.
     */
    private function __construct(string $code)
    {
        $this->checkNotValidChar($code);
        $this->checkHashSumVinCode($code);
        $upperCaseVinCode = strtoupper($code);
        $this->code = $upperCaseVinCode;
    }

    /**
     * Create VinCode from string.
     * @param string $vinCode VinCode.
     * @return VinCode
     * @throws InvalidArgumentException Exception.
     */
    public static function createFromString(string $vinCode): self
    {
        $trimCode = trim($vinCode);
        $clearDashCode = str_replace('-', '', $trimCode);
        $clearSpaceCode = str_replace(' ', '', $clearDashCode);
        $lowerCaseVinCode = strtolower($clearSpaceCode);

        $splitVin = str_split($lowerCaseVinCode);
        $countChar = count($splitVin);
        if ($countChar !== 17) {
            throw LengthNotValidException::create($countChar);
        }

        return new self($lowerCaseVinCode);
    }

    /**
     * VinCode to string form.
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }

    /**
     * Checking for valid chars.
     * @param string $code Code.
     * @return void
     * @throws InvalidArgumentException Exception.
     */
    private function checkNotValidChar(string $code): void
    {
        $arrayCode = str_split($code);
        foreach ($arrayCode as $char) {
            if (in_array($char, $this->availableChar)) {
                continue;
            }
            throw NotValidLetterException::create($code, $code);
        }
    }

    /**
     * Check for valid hash sum.
     * @param string $vin VinCode.
     * @return void
     * @throws InvalidArgumentException Exception.
     */
    private function checkHashSumVinCode(string $vin): void
    {
        $sum = 0;

        $vinCodeChars = str_split($vin);
        foreach ($vinCodeChars as $key => $vinCodeChar) {
            if (is_numeric($vinCodeChar)) {
                $sum += (int) $vinCodeChar * $this->weights[$key];
                continue;
            }

            $sum += $this->transliterations[$vinCodeChar] * $this->weights[$key];
        }

        $checkDigit = $sum % 11;
        if ($checkDigit === 10 && $vinCodeChars[8] === 'x') {
            return;
        }

        if ($checkDigit === (int) $vinCodeChars[8]) {
            return;
        }

        throw CheckSumNotValidException::create($vin);
    }
}

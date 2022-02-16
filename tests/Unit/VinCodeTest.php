<?php

namespace Tests\Unit;

use CheckvinVincode\VinCode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class VinCodeTest - тест VO
 */
class VinCodeTest extends TestCase
{
    /**
     * Тестируем валидное создание VO.
     *
     * @return void
     */
    public function testSuccessCreateVinCode()
    {
        $vincode = VinCode::createFromString('1FM5K7D85HGB31870');
        $this->assertSame((string) $vincode, '1FM5K7D85HGB31870');
    }

    /**
     * Тестируем что при передаче невалидных данных винкод не создается
     *
     * @param string $failedVinCode Невалидный vin
     *
     * @dataProvider failedCreateVinCodeDataProvider Провайдер невалидных данных
     */
    public function testFailedCreateVinCode(string $failedVinCode)
    {
        $this->expectException(InvalidArgumentException::class);

        VinCode::createFromString($failedVinCode);
    }

    /**
     * Провайдер некоректных данных.
     *
     * @return array
     */
    public function failedCreateVinCodeDataProvider()
    {
        return [
            ['test'],
            ['1FM5K7D85HGB3187'],
            ['1FM5K7D85HGB318700'],
            ['0'],
            [''],
            ['1'],
        ];
    }
}

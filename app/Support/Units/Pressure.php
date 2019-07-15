<?php

namespace App\Support\Units;

use App\Interfaces\Unit;
use PhpUnitsOfMeasure\PhysicalQuantity\Pressure as PressureUnit;

/**
 * Composition for the converter
 */
class Pressure extends Unit
{
    public $responseUnits = [
        'atm',
        'hPa',
    ];

    /**
     * @param float  $value
     * @param string $unit
     *
     * @throws \PhpUnitsOfMeasure\Exception\NonNumericValue
     * @throws \PhpUnitsOfMeasure\Exception\NonStringUnitName
     */
    public function __construct(float $value, string $unit)
    {
        $this->unit = setting('units.temperature');
        $this->instance = new PressureUnit($value, $unit);
    }
}

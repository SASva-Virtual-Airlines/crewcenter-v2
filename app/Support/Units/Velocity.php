<?php

namespace App\Support\Units;

use App\Interfaces\Unit;
use PhpUnitsOfMeasure\PhysicalQuantity\Velocity as VelocityUnit;

/**
 * Class Velocity
 */
class Velocity extends Unit
{
    public $responseUnits = [
        'km/h',
        'knots',
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
        $this->unit = setting('units.speed');
        $this->instance = new VelocityUnit($value, $unit);
    }
}

<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface CourseInterface
 * @package Calculation\Utils\Calculation
 */
interface CourseInterface
{
    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculate(PairInterface $pair, float $percent = null): float;

}
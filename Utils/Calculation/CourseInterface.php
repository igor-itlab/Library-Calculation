<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utlis\Exchange\PairInterface;

/**
 * Interface CourseInterface
 * @package Calculation\Utils\Calculation
 */
interface CourseInterface
{
    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateCourse(PairInterface $pair): float;

}
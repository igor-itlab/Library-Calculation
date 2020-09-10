<?php


namespace Calculation\Service;


use Calculation\Utils\Calculation\CourseInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Course
 * @package Calculation\Service
 */
class Course implements CourseInterface
{

    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculate(PairInterface $pair): float
    {
        $course = $pair->getOutObject()->getCurrency()->getOutRate()
            * ((100 + $pair->getInPercent()) / 100)
            * ((100 - $pair->getInObject()->getPaymentSystem()->getPrice()) / 100);

        return $pair->getInObject()->getCurrency()->getInRate() * $course;
    }
}
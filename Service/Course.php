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
        $inRate = $pair->getInObject()->getCurrency()->getInRate() * ((100 - $pair->getInObject()->getPaymentSystem(
                    )->getPrice()) / 100);
        $outRate = $pair->getOutObject()->getCurrency()->getOutRate() * ((100 - $pair->getOutObject()->getPaymentSystem(
                    )->getPrice()) / 100);

        return $inRate * $outRate * ((100 + $pair->getPercent()) / 100);
    }
}

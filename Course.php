<?php


namespace Calculation;


use Calculation\Entity\PairInterface;
use Calculation\Entity\PairUnitInterface;

/**
 * Class Course
 * @package Calculation
 */
class Course
{
    public static function calculateCourse(PairInterface $pair): float
    {
        $payinCourse = $payout->getCurrency()->getCoursePayout()
            * ((100 + $pair->getPercent()) / 100)
            * ((100 - $payin->getPaymentSystem()->getCostPrice()) / 100);

        $payoutCourse = $payin->getCurrency()->getCoursePayout()
            * ((100 - $pair->getPercent()) / 100)
            * ((100 - $payout->getPaymentSystem()->getCostPrice()) / 100);

        return $payinCourse * $payoutCourse;
    }
}
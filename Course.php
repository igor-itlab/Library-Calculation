<?php


namespace Calculation;


use Calculation\Entity\PairInterface;
use Calculation\Entity\PairUnitInterface;

class Course
{
    public static function calculateCourse(PairInterface $pair): float
    {
        $payinCourse = $pair->getPayoutObject()->getCurrency()->getCoursePayout()
            * ((100 + $pair->getPercentPayin()) / 100)
            * ((100 - $pair->getPayinObject()->getPaymentSystem()->getCostPrice()) / 100);

        $payoutCourse = $pair->getPayinObject()->getCurrency()->getCoursePayout()
            * ((100 - $pair->getPercentPayout()) / 100)
            * ((100 - $pair->getPayoutObject()->getPaymentSystem()->getCostPrice()) / 100);

        return $payinCourse * $payoutCourse;
    }
}
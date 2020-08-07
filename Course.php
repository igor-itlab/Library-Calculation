<?php


namespace Calculation;


use Calculation\Entity\PairInterface;
use Calculation\Entity\PairUnitInterface;

class Course
{
    public static function calculateCourse(PairInterface $pair, PairUnitInterface $payin, PairUnitInterface $payout): float
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
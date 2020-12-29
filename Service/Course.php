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
        $inRate = $pair->getPayment()->getCurrency()->getPaymentRateForCalc() * ((100 - $pair->getPayment(
                    )->getPaymentSystem()->getPrice()) / 100);
        $outRate = $pair->getPayout()->getCurrency()->getPayoutRateForCalc() * ((100 - $pair->getPayout(
                    )->getPaymentSystem()->getPrice()) / 100);

        if ($pair->getPayout()->getCurrency()->getTag() == 'CRYPTO') {
            return $outRate / $inRate * ((100 - $pair->getPercent()) / 100);
        } else {
            return $outRate / ($inRate * ((100 - $pair->getPercent()) / 100));
        }
    }
}

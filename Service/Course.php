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
     * @param float|null $percent
     * @return float
     */
    public static function calculate(PairInterface $pair, float $percent = null): float
    {
        $inRate = $pair->getPayment()->getCurrency()->getPaymentRateForCalc() * ((100 - $pair->getPayment()->getPaymentSystem()->getPrice()) / 100);
        $outRate = $pair->getPayout()->getCurrency()->getPayoutRateForCalc() * ((100 - $pair->getPayout()->getPaymentSystem()->getPrice()) / 100);

        $pairPercent = $pair->getPercent();

        if ($percent) {
            $pairPercent = $percent;
        }

        if ($pair->getPayout()->getCurrency()->getTag() == 'CRYPTO') {
            return $outRate / $inRate * ((100 + $pairPercent) / 100);
        } else {
            return $outRate / $inRate * ((100 + $pairPercent) / 100);
        }
    }
}

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
        $inRate = $pair->getPayment()->getCurrency()->getPaymentRateForCalc();
        $outRate = $pair->getPayout()->getCurrency()->getPayoutRateForCalc();

        $inCostPrice = $pair->getPayment()->getPaymentSystem()->getPrice();
        $outCostPrice = $pair->getPayout()->getPaymentSystem()->getPrice();

        $pairPercent = $pair->getPercent();

        if ($percent) {
            $pairPercent = $percent;
        }

        $lastFee = (100 - ($pairPercent - $inCostPrice + $outCostPrice)) / 100;

        if ($pair->getPayout()->getCurrency()->getTag() == 'CRYPTO') {
            return $outRate / $inRate * $lastFee;
        } else {
            return $outRate / $inRate * $lastFee;
        }
    }
}

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

        $lastFee = self::calculateLastFee($pair, $percent);

        if ($pair->getPayout()->getCurrency()->getTag() == 'CRYPTO') {
            return $outRate / $inRate * ((100 - $lastFee) / 100);
        } else {
            return $outRate / $inRate * ((100 - $lastFee) / 100);
        }
    }

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float|int
     */
    public static function calculateLastFee(PairInterface $pair, float $percent = null)
    {
        $inCostPrice = $pair->getPayment()->getPaymentSystem()->getPrice();
        $outCostPrice = $pair->getPayout()->getPaymentSystem()->getPrice();

        $pairPercent = $pair->getPercent();

        if ($percent) {
            $pairPercent = $percent;
        }

        return $pairPercent - $inCostPrice + $outCostPrice;
    }
}

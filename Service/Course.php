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
            return $inRate / $outRate * ((100 - $lastFee) / 100);
        } else {
            return $inRate / $outRate * ((100 - $lastFee) / 100);
        }
    }

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float|int
     */
    public static function calculateLastFee(PairInterface $pair, float $percent = null)
    {
        $inCostPrice = $pair->getPayment()->getPrice();
        $outCostPrice = $pair->getPayout()->getPrice();

        $pairPercent = $pair->getPercent();

        if ($percent) {
            $pairPercent = $percent;
        }

        return $pairPercent - $inCostPrice + $outCostPrice;
    }

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float|int
     */
    public static function calculateSurcharge(PairInterface $pair, float $percent = null)
    {
        $lastFee = self::calculateLastFee($pair, $percent);

        $inPercent = $pair->getPayment()->getFee()->getPercent();
        $outPercent = $pair->getPayout()->getFee()->getPercent();

        return $lastFee + $inPercent + $outPercent;
    }
}

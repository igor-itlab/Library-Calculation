<?php


namespace Calculation\Service;


use Calculation\Utils\Calculation\CourseInterface;
use Calculation\Utils\Exchange\CurrencyInterface;
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
        $paymentCurrency = $pair->getPayment()->getCurrency();
        $payoutCurrency = $pair->getPayout()->getCurrency();

        $paymentRate = self::getRate($paymentCurrency->getTag(), $paymentCurrency->getPurchaseRate());
        $payoutRate = self::getRate($payoutCurrency->getTag(), $payoutCurrency->getSellingRate());

        $lastFee = self::calculateLastFee($pair, $percent);

        return $paymentRate / $payoutRate * ((100 - $lastFee) / 100);
    }

    /**
     * @param string $tag
     * @param float $rate
     * @return float|int
     */
    public static function getRate(string $tag, float $rate): float
    {
        if ($tag === CurrencyInterface::CURRENCY) {
            return 1 / $rate;
        }

        return $rate;
    }

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculateLastFee(PairInterface $pair, float $percent = null): float
    {
        $paymentPrice = $pair->getPayment()->getPrice();
        $payoutPrice = $pair->getPayout()->getPrice();

        $pairPercent = $pair->getPercent();

        if ($percent) {
            $pairPercent = $percent;
        }

        return $pairPercent - $paymentPrice + $payoutPrice;
    }

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculateSurcharge(PairInterface $pair, float $percent = null): float
    {
        $lastFee = self::calculateLastFee($pair, $percent);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();
        $payoutPercent = $pair->getPayout()->getFee()->getPercent();

        return $lastFee + $paymentPercent + $payoutPercent;
    }
}

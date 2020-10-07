<?php


namespace Calculation\Service\States;

use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Calculation\RatesInterface;
use Calculation\Utils\Exchange\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface, RatesInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getPrimeFee()->getMin() + $pair->getOutObject()->getMarkupFee()->getMin();
        $payoutMin = $pair->getInObject()->getPrimeFee()->getMin() + $pair->getInObject()->getMarkupFee()->getMin();

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getInObject()->getAmount()) {
            $pair->getOutObject()->setMin(ceil($pair->getInObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMin($pair->getInObject()->getAmount());
        } else {
            $pair->getOutObject()->setMin(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
            $pair->getOutObject()->setMin($pair->getInObject()->getAmount());
        }
    }

    /**
     * @param PairInterface $pair
     * @param float|null $amount
     * @return void
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null): void
    {
        if ($amount === null) {
            self::calculateMin($pair);
            $amount = $pair->getOutObject()->getMin();
        }

        $pair->getOutObject()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->getPrimeFee()->getPercent() + $pair->getInObject()->getMarkupFee(
            )->getPercent();
        $paymentConstant = $pair->getInObject()->getPrimeFee()->getConstant() + $pair->getInObject()->getMarkupFee(
            )->getConstant();

        $payoutPercent = $pair->getOutObject()->getPrimeFee()->getPercent() + $pair->getOutObject()->getMarkupFee(
            )->getPercent();
        $payoutConstant = $pair->getOutObject()->getPrimeFee()->getConstant() + $pair->getOutObject()->getMarkupFee(
            )->getConstant();

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp * $course;

        $pair->getInObject()->setAmount(($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100));
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getOutObject()->getPrimeFee()->getMax() + $pair->getOutObject()->getMarkupFee()->getMax();
        $payoutMax = $pair->getInObject()->getPrimeFee()->getMax() + $pair->getInObject()->getMarkupFee()->getMax();

        self::calculateAmount($pair, $payoutMax);

        if ($paymentMax < $pair->getInObject()->getAmount()) {
            $pair->getOutObject()->setMax(ceil($paymentMax));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        } else {
            $pair->getOutObject()->setMax(ceil($pair->getInObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        }
    }

    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateRates(PairInterface $pair): float
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->getPrimeFee()->getPercent() + $pair->getInObject()->getMarkupFee(
            )->getPercent();

        $payoutPercent = $pair->getOutObject()->getPrimeFee()->getPercent() + $pair->getOutObject()->getMarkupFee(
            )->getPercent();

        return ((100 - $paymentPercent) / 100)
            * ($course * ((100 - $payoutPercent) / 100));
    }
}

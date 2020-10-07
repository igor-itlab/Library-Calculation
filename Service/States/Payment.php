<?php


namespace Calculation\Service\States;


use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Calculation\RatesInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Payment
 * @package Calculation
 */
class Payment implements CalculationInterface, RatesInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getPrimeFee()->getMin() + $pair->getInObject()->getMarkupFee()->getMin();
        $payoutMin = $pair->getOutObject()->getPrimeFee()->getMin() + $pair->getOutObject()->getMarkupFee()->getMin();

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getOutObject()->getAmount()) {
            $pair->getInObject()->setMin(ceil($pair->getOutObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getOutObject()->getAmount()));
            $pair->getOutObject()->setMin($pair->getOutObject()->getAmount());
        } else {
            $pair->getInObject()->setMin(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
            $pair->getOutObject()->setMin($pair->getOutObject()->getAmount());
        }
    }

    /**
     * @param PairInterface $pair
     * @param float|null $amount
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null): void
    {
        if ($amount === null) {
            self::calculateMin($pair);
            $amount = $pair->getInObject()->getPrimeFee()->getMin() + $pair->getInObject()->getMarkupFee()->getMin();
        }

        $pair->getInObject()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->getPrimeFee()->getPercent() + $pair->getInObject()->getMarkupFee(
            )->getPercent();
        $paymentConstant = $pair->getInObject()->getPrimeFee()->getConstant() + $pair->getInObject()->getMarkupFee(
            )->getConstant();

        $payoutPercent = $pair->getOutObject()->getPrimeFee()->getPercent() + $pair->getOutObject()->getMarkupFee(
            )->getPercent();
        $payoutConstant = $pair->getOutObject()->getPrimeFee()->getConstant() + $pair->getOutObject()->getMarkupFee(
            )->getConstant();

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getOutObject()->setAmount($cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getInObject()->getPrimeFee()->getMax() + $pair->getInObject()->getMarkupFee()->getMax();
        $payoutMax = $pair->getOutObject()->getPrimeFee()->getMax() + $pair->getOutObject()->getMarkupFee()->getMax();

        self::calculateAmount($pair, $payoutMax);

        if ($paymentMax < $pair->getOutObject()->getAmount()) {
            $pair->getInObject()->setMax(ceil($paymentMax));
            self::calculateAmount($pair, ceil($paymentMax));
            $pair->getOutObject()->setMax($pair->getOutObject()->getAmount());
        } else {
            $pair->getInObject()->setMax(ceil($pair->getOutObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getOutObject()->getAmount()));
            $pair->getOutObject()->setMax($pair->getOutObject()->getAmount());
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

        return ((100 + $payoutPercent) / 100)
            * ($course * ((100 + $paymentPercent) / 100));
    }
}

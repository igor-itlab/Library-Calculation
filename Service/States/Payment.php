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
        $paymentMin = $pair->getPayment()->getPrimeFee()->getMin() + $pair->getPayment()->getMarkupFee()->getMin();
        $payoutMin = $pair->getPayout()->getPrimeFee()->getMin() + $pair->getPayout()->getMarkupFee()->getMin();

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getPayout()->getAmount()) {
            $pair->getPayment()->setMin(ceil($pair->getPayout()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getPayout()->getAmount()));
            $pair->getPayout()->setMin($pair->getPayout()->getAmount());
        } else {
            $pair->getPayment()->setMin(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
            $pair->getPayout()->setMin($pair->getPayout()->getAmount());
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
            $amount = $pair->getPayment()->getPrimeFee()->getMin() + $pair->getPayment()->getMarkupFee()->getMin();
        }

        $pair->getPayment()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getPrimeFee()->getPercent() + $pair->getPayment()->getMarkupFee(
            )->getPercent();
        $paymentConstant = $pair->getPayment()->getPrimeFee()->getConstant() + $pair->getPayment()->getMarkupFee(
            )->getConstant();

        $payoutPercent = $pair->getPayout()->getPrimeFee()->getPercent() + $pair->getPayout()->getMarkupFee(
            )->getPercent();
        $payoutConstant = $pair->getPayout()->getPrimeFee()->getConstant() + $pair->getPayout()->getMarkupFee(
            )->getConstant();

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getPayout()->setAmount($cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getPayment()->getPrimeFee()->getMax() + $pair->getPayment()->getMarkupFee()->getMax();
        $payoutMax = $pair->getPayout()->getPrimeFee()->getMax() + $pair->getPayout()->getMarkupFee()->getMax();

        self::calculateAmount($pair, $payoutMax);

        if ($paymentMax < $pair->getPayout()->getAmount()) {
            $pair->getPayment()->setMax(ceil($paymentMax));
            self::calculateAmount($pair, ceil($paymentMax));
            $pair->getPayout()->setMax($pair->getPayout()->getAmount());
        } else {
            $pair->getPayment()->setMax(ceil($pair->getPayout()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getPayout()->getAmount()));
            $pair->getPayout()->setMax($pair->getPayout()->getAmount());
        }
    }


    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateRates(PairInterface $pair): float
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getPrimeFee()->getPercent() + $pair->getPayment()->getMarkupFee(
            )->getPercent();

        $payoutPercent = $pair->getPayout()->getPrimeFee()->getPercent() + $pair->getPayout()->getMarkupFee(
            )->getPercent();

        return ((100 + $payoutPercent) / 100)
            * ($course * ((100 + $paymentPercent) / 100));
    }
}

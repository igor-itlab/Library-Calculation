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
        $paymentMin = $pair->getPayout()->getPrimeFee()->getMin() + $pair->getPayout()->getMarkupFee()->getMin();
        $payoutMin = $pair->getPayment()->getPrimeFee()->getMin() + $pair->getPayment()->getMarkupFee()->getMin();

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getPayment()->getAmount()) {
            $pair->getPayout()->setMin(ceil($pair->getPayment()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getPayment()->getAmount()));
            $pair->getPayment()->setMin($pair->getPayment()->getAmount());
        } else {
            $pair->getPayout()->setMin(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
            $pair->getPayout()->setMin($pair->getPayment()->getAmount());
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
            $amount = $pair->getPayout()->getMin();
        }

        $pair->getPayout()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getPrimeFee()->getPercent() + $pair->getPayment()->getMarkupFee(
            )->getPercent();
        $paymentConstant = $pair->getPayment()->getPrimeFee()->getConstant() + $pair->getPayment()->getMarkupFee(
            )->getConstant();

        $payoutPercent = $pair->getPayout()->getPrimeFee()->getPercent() + $pair->getPayout()->getMarkupFee(
            )->getPercent();
        $payoutConstant = $pair->getPayout()->getPrimeFee()->getConstant() + $pair->getPayout()->getMarkupFee(
            )->getConstant();

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp * $course;

        $pair->getPayment()->setAmount(($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100));
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getPayout()->getPrimeFee()->getMax() + $pair->getPayout()->getMarkupFee()->getMax();
        $payoutMax = $pair->getPayment()->getPrimeFee()->getMax() + $pair->getPayment()->getMarkupFee()->getMax();

        self::calculateAmount($pair, $payoutMax);

        if ($paymentMax < $pair->getPayment()->getAmount()) {
            $pair->getPayout()->setMax(ceil($paymentMax));
            self::calculateAmount($pair, ceil($pair->getPayment()->getAmount()));
            $pair->getPayment()->setMax($pair->getPayment()->getAmount());
        } else {
            $pair->getPayout()->setMax(ceil($pair->getPayment()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getPayment()->getAmount()));
            $pair->getPayment()->setMax($pair->getPayment()->getAmount());
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

        return ((100 - $paymentPercent) / 100)
            * ($course * ((100 - $payoutPercent) / 100));
    }
}

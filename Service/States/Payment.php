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
        $paymentMin = $pair->getPayment()->getFee()->getMin();
        $payoutMin = $pair->getPayout()->getFee()->getMin();

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
            $amount = $pair->getPayment()->getFee()->getMin();
        }

        $pair->getPayment()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();
        $paymentConstant = $pair->getPayment()->getFee()->getConstant();

        $payoutPercent = $pair->getPayout()->getFee()->getPercent();
        $payoutConstant = $pair->getPayout()->getFee()->getConstant();

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getPayout()->setAmount($cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getPayment()->getFee()->getMax();
        $payoutMax = $pair->getPayout()->getFee()->getMax();

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
        $course = self::calculateCourse($pair);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();

        $payoutPercent = $pair->getPayout()->getFee()->getPercent();

        return ((100 + $payoutPercent) / 100)
            * ($course * ((100 + $paymentPercent) / 100));
    }

    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateCourse(PairInterface $pair): float
    {
        $inRate = $pair->getPayment()->getCurrency()->getPayoutRate() * ((100 - $pair->getPayment()->getPaymentSystem(
                    )->getPrice()) / 100);
        $outRate = $pair->getPayout()->getCurrency()->getPaymentRate() * ((100 - $pair->getPayout()->getPaymentSystem(
                    )->getPrice()) / 100);

        return $inRate / $outRate * ((100 - $pair->getPercent()) / 100);
    }
}

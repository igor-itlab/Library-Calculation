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
        $paymentMin = $pair->getInObject()->getFee()['limits']['min'] + $pair->getInObject()->getService()->getInFee(
            )['limits']['min'];
        $payoutMin = $pair->getOutObject()->getFee()['limits']['min'] + $pair->getOutObject()->getService()->getOutFee(
            )['limits']['min'];

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
            $amount = $pair->getInObject()->getMin();
        }

        $pair->getInObject()->setAmount($amount);

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->getFee()['percent'] + $pair->getInObject()->getService()->getInFee(
            )['percent'];
        $paymentConstant = $pair->getInObject()->getFee()['constant'] + $pair->getInObject()->getService()->getInFee(
            )['constant'];

        $payoutPercent = $pair->getOutObject()->getFee()['percent'] + $pair->getOutObject()->getService()->getOutFee(
            )['percent'];
        $payoutConstant = $pair->getOutObject()->getFee()['constant'] + $pair->getOutObject()->getService()->getOutFee(
            )['constant'];

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getOutObject()->setAmount($cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getFee()['limits']['max'] + $pair->getInObject()->getService()->getInFee(
            )['limits']['max'];
        $payoutMin = $pair->getOutObject()->getFee()['limits']['max'] + $pair->getOutObject()->getService()->getOutFee(
            )['limits']['max'];

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getOutObject()->getAmount()) {
            $pair->getInObject()->setMax(ceil($paymentMin));
            self::calculateAmount($pair, ceil($paymentMin));
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

        $paymentPercent = $pair->getInObject()->getFee()['percent'] + $pair->getInObject()->getService()->getInFee(
            )['percent'];

        $payoutPercent = $pair->getOutObject()->getFee()['percent'] + $pair->getOutObject()->getService()->getOutFee(
            )['percent'];

        return ((100 + $payoutPercent) / 100)
            * ($course * ((100 + $paymentPercent) / 100));
    }
}

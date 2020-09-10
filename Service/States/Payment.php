<?php


namespace Calculation\Service\States;


use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Payment
 * @package Calculation
 */
class Payment implements CalculationInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['limits']['min'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['limits']['min'];

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
        if (!$amount) {
            self::calculateMin($pair);
            $amount = $pair->getInObject()->getMin();
        }

        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->inFee()['percent'];
        $paymentConstant = $pair->getInObject()->inFee()['constant'];

        $payoutPercent = $pair->getOutObject()->outFee()['percent'];
        $payoutConstant = $pair->getOutObject()->outFee()['constant'];

        $currencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getOutObject()->setAmount($cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['limits']['max'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['limits']['max'];

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
}

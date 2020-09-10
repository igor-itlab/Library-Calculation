<?php


namespace Calculation\Service\States;

use Calculation\Service\Course;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Exchange\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getService()->inFee()['min'];
        $payoutMin = $pair->getInObject()->getService()->inFee()['min'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getOutObject()->setMin(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getInObject()->setMin($tmp2);
        } else {
            $pair->getOutObject()->setMin(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getOutObject()->setMin($tmp2);
        }
    }

    /**
     * @param float $amount
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateAmount(float $amount, PairInterface $pair): float
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getInObject()->inFee()['percent'];
        $paymentConstant = $pair->getInObject()->inFee()['constant'];

        $payoutPercent = $pair->getOutObject()->outFee()['percent'];
        $payoutConstant = $pair->getOutObject()->outFee()['constant'];

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp * $course;

        return ($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100);
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getService()->inFee()['max'];
        $payoutMin = $pair->getInObject()->getService()->inFee()['max'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getOutObject()->setMax(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getInObject()->setMax($tmp2);
        } else {
            $pair->getOutObject()->setMax(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getInObject()->setMax($tmp2);
        }
    }
}
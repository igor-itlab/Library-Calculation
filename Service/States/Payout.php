<?php


namespace Calculation\Service\States;

use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Calculation\CourseInterface;
use Calculation\Utlis\Exchange\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface, CourseInterface
{
    /**
     * @param float $amount
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateAmount(float $amount, PairInterface $pair): float
    {
        $course = self::calculateCourse($pair);

        $paymentPercent = $pair->getInObject()->inFee()['percent'];
        $paymentConstant = $pair->getInObject()->inFee()['constant'];

        $payoutPercent = $pair->getOutObject()->inFee()['percent'];
        $payoutConstant = $pair->getOutObject()->inFee()['constant'];

        $cryptocurrencyTmp = $amount - ($amount * $paymentPercent) / 100 - $paymentConstant;
        $currencyTmp = $cryptocurrencyTmp * $course;

        return $currencyTmp * (1 - $payoutPercent / 100) - $payoutConstant;
    }

    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateCourse(PairInterface $pair): float
    {
        $course = $pair->getInObject()->getCurrency()->getInRate()
            * ((100 + $pair->getOutPercent()) / 100)
            * ((100 - $pair->getOutObject()->getPaymentSystem()->getPrice()) / 100);

        return $pair->getOutObject()->getCurrency()->getOutRate() * $course;
    }

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
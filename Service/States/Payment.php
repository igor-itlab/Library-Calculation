<?php


namespace Calculation;


use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Calculation\CourseInterface;
use Calculation\Utlis\Exchange\PairInterface;

/**
 * Class Payment
 * @package Calculation
 */
class Payment implements CalculationInterface, CourseInterface
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

        $currencyTmp = $amount - ($amount * $paymentPercent) / $paymentConstant;
        $cryptocurrencyTmp = $currencyTmp / $course;

        return $cryptocurrencyTmp * (1 - $payoutPercent / 100) - $payoutConstant;
    }

    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateCourse(PairInterface $pair): float
    {
        $course = $pair->getOutObject()->getCurrency()->getOutRate()
            * ((100 + $pair->getInPercent()) / 100)
            * ((100 - $pair->getInObject()->getPaymentSystem()->getCostPrice()) / 100);

        return $pair->getInObject()->getCurrency()->getInRate() * $course;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['min'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['min'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getInObject()->setMin(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getOutObject()->setMin($tmp2);
        } else {
            $pair->getInObject()->setMin(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getOutObject()->setMin($tmp2);
        }
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getInObject()->getService()->inFee()['max'];
        $payoutMin = $pair->getOutObject()->getService()->inFee()['max'];

        $tmp = self::calculateAmount($payoutMin, $pair);

        if ($paymentMin < $tmp) {
            $pair->getInObject()->setMax(ceil($paymentMin));
            $tmp2 = self::calculateAmount(ceil($paymentMin), $pair);
            $pair->getOutObject()->setMax($tmp2);
        } else {
            $pair->getInObject()->setMax(ceil($tmp));
            $tmp2 = self::calculateAmount(ceil($tmp), $pair);
            $pair->getOutObject()->setMax($tmp2);
        }
    }
}

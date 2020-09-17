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
        $paymentMin = $pair->getOutObject()->getFee()['limits']['min'] + $pair->getOutObject()->getService()->getOutFee()['limits']['min'];
        $payoutMin = $pair->getInObject()->getFee()['limits']['min'] + $pair->getInObject()->getService()->getInFee()['limits']['min'];

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

        $paymentPercent = $pair->getInObject()->getFee()['percent'] + $pair->getInObject()->getService()->getInFee()['percent'];
        $paymentConstant = $pair->getInObject()->getFee()['constant'] + $pair->getInObject()->getService()->getInFee()['constant'];

        $payoutPercent = $pair->getOutObject()->getFee()['percent'] + $pair->getOutObject()->getService()->getOutFee()['percent'];
        $payoutConstant = $pair->getOutObject()->getFee()['constant'] + $pair->getOutObject()->getService()->getOutFee()['constant'];

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp * $course;

        $pair->getInObject()->setAmount(($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100));
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMin = $pair->getOutObject()->getFee()['limits']['max'] + $pair->getOutObject()->getService()->getOutFee()['limits']['max'];
        $payoutMin = $pair->getInObject()->getFee()['limits']['max'] + $pair->getInObject()->getService()->getInFee()['limits']['max'];

        self::calculateAmount($pair, $payoutMin);

        if ($paymentMin < $pair->getInObject()->getAmount()) {
            $pair->getOutObject()->setMax(ceil($paymentMin));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        } else {
            $pair->getOutObject()->setMax(ceil($pair->getInObject()->getAmount()));
            self::calculateAmount($pair, ceil($pair->getInObject()->getAmount()));
            $pair->getInObject()->setMax($pair->getInObject()->getAmount());
        }
    }
}

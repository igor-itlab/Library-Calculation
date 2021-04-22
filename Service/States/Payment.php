<?php


namespace Calculation\Service\States;


use Calculation\Service\Course;
use Calculation\Service\Limits;
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
     * @param float|null $amount
     * @param float|null $percent
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null, float $percent = null): void
    {
        if ($amount === null) {
            Limits::calculateMin($pair);
            $amount = $pair->getPayment()->getAmount();
        } else {
            $pair->getPayment()->setAmount($amount);
        }

        $course = Course::calculate($pair, $percent);

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
     * @return float
     */
    public static function calculateRates(PairInterface $pair): float
    {
        $course = Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();

        $payoutPercent = $pair->getPayout()->getFee()->getPercent();

        return ((100 + $payoutPercent) / 100)
            * ($course * ((100 + $paymentPercent) / 100));
    }
}

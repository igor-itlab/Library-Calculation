<?php


namespace Calculation\Service\States;

use Calculation\Service\Course;
use Calculation\Service\Limits;
use Calculation\Utils\Calculation\CalculationInterface;
use Calculation\Utils\Calculation\RatesInterface;
use Calculation\Utils\Exchange\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface
{

    /**
     * @param PairInterface $pair
     * @param float|null $amount
     * @param float|null $percent
     * @return void
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null, float $percent = null): void
    {
        if ($amount === null) {
            Limits::calculateMin($pair);
            $amount = $pair->getPayout()->getMin();
        }

        $pair->getPayout()->setAmount($amount);

        $course = Course::calculate($pair, $percent);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();
        $paymentConstant = $pair->getPayment()->getFee()->getConstant();

        $payoutPercent = $pair->getPayout()->getFee()->getPercent();
        $payoutConstant = $pair->getPayout()->getFee()->getConstant();

        $currencyTmp = ($amount + $payoutConstant) / (1 - $payoutPercent / 100);
        $cryptocurrencyTmp = $currencyTmp / $course;

        $pair->getPayment()->setAmount(($cryptocurrencyTmp + $paymentConstant) / (1 - $paymentPercent / 100));
    }
    
}

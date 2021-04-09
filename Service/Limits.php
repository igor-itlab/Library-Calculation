<?php


namespace Calculation\Service;


use Calculation\Service\States\Payment;
use Calculation\Service\States\Payout;
use Calculation\Utils\Calculation\LimitsInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Limits
 * @package Calculation\Service
 */
class Limits implements LimitsInterface
{

    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void
    {
        $paymentMin = self::addPairPercent($pair->getPayment()->getFee()->getMin(), $pair->getPercent());
        $payoutMin = self::addPairPercent($pair->getPayout()->getFee()->getMin(), $pair->getPercent());

        Payment::calculateAmount($pair, $paymentMin);

        if ($payoutMin < $pair->getPayout()->getAmount()) {
            $pair->getPayout()->setMin($pair->getPayout()->getAmount());
            $pair->getPayment()->setMin($paymentMin);
        } else {
            $pair->getPayout()->setMin($payoutMin);
            Payout::calculateAmount($pair, $payoutMin);
            $pair->getPayment()->setMin($pair->getPayment()->getAmount());
        }
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $paymentMax = $pair->getPayment()->getFee()->getMax();
        $payoutMax = $pair->getPayout()->getFee()->getMax();

        Payment::calculateAmount($pair, $paymentMax);

        if ($payoutMax < $pair->getPayout()->getAmount()) {
            $pair->getPayout()->setMax($payoutMax);
            Payout::calculateAmount($pair, $payoutMax);
            $pair->getPayment()->setMax($pair->getPayment()->getAmount());
        } else {
            $pair->getPayment()->setMax($paymentMax);
            Payment::calculateAmount($pair, $paymentMax);
            $pair->getPayout()->setMax($pair->getPayout()->getAmount());
        }
    }

    public static function addPairPercent(float $amount, float $percent)
    {
        return $amount + ($amount * $percent) / 100;
    }
}

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
        $payment = $pair->getPayment();
        $payout = $pair->getPayout();

        $paymentMin = self::calculatePercent($payment->getFee()->getMin(), $pair->getPercent());
        $payoutMin = self::calculatePercent($payout->getFee()->getMin(), $pair->getPercent());

        Payment::calculateAmount($pair, $paymentMin);

        if ($payoutMin < $payout->getAmount()) {
            $payout->setMin($payout->getAmount());
            $payment->setMin($paymentMin);
        } else {
            $payout->setMin($payoutMin);
            Payout::calculateAmount($pair, $payoutMin);
            $payment->setMin($payment->getAmount());
        }
    }

    /**
     * @param float $amount
     * @param float $percent
     * @return float
     */
    public static function calculatePercent(float $amount, float $percent): float
    {
        return $amount + ($amount * $percent) / 100;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void
    {
        $payment = $pair->getPayment();
        $payout = $pair->getPayout();

        $paymentMax = $payment->getFee()->getMax();
        $payoutMax = $payout->getFee()->getMax();

        Payment::calculateAmount($pair, $paymentMax);

        if ($payoutMax < $pair->getPayout()->getAmount()) {
            $payout->setMax($payoutMax);
            Payout::calculateAmount($pair, $payoutMax);
            $payment->setMax($payment->getAmount());
        } else {
            $payment->setMax($paymentMax);
            Payment::calculateAmount($pair, $paymentMax);
            $payout->setMax($payout->getAmount());
        }
    }
}

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
        $paymentMin = $pair->getPayment()->getFee()->getMin();
        $payoutMin = $pair->getPayout()->getFee()->getMin();

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
}

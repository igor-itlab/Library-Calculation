<?php


namespace Calculation\Service;


use Calculation\Utils\Calculation\RateInterface;
use Calculation\Utils\Exchange\PairInterface;

/**
 * Class Rate
 * @package Calculation\Service
 */
class Rate implements RateInterface
{
    /**
     * @param PairInterface $pair
     * @param string $direction
     * @return int|float
     */
    public static function calculate(PairInterface $pair, string $direction): float
    {
        $course = $direction === PairInterface::PAYMENT ? Course::calculate($pair) : 1 / Course::calculate($pair);

        $paymentPercent = $pair->getPayment()->getFee()->getPercent();
        $payoutPercent = $pair->getPayout()->getFee()->getPercent();

        return ((100 + $paymentPercent) / 100) * $course * ((100 - $payoutPercent) / 100);
    }
}
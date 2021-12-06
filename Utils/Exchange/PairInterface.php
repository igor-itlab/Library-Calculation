<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface PairInterface
 * @package Calculation\Utils\Exchange
 */
interface PairInterface
{
    /**
     * @const PAYMENT
     */
    public const PAYMENT = "payment";

    /**
     * @const PAYOUT
     */
    public const PAYOUT = "payout";

    /**
     * @return float
     */
    public function getPercent(): float;

    /**
     * @return PairUnitInterface
     */
    public function getPayment(): PairUnitInterface;

    /**
     * @return PairUnitInterface
     */
    public function getPayout(): PairUnitInterface;
}

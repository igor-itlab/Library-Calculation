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
     * @return float|null
     */
    public function getPercent(): ?float;

    /**
     * @return PairUnitInterface|null
     */
    public function getPayment(): ?PairUnitInterface;

    /**
     * @return PairUnitInterface|null
     */
    public function getPayout(): ?PairUnitInterface;
}

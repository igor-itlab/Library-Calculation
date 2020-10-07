<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface PairInterface
 * @package Calculation\Utils\Exchange
 */
interface PairInterface
{
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

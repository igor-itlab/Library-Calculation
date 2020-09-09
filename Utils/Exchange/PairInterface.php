<?php

namespace Calculation\Utlis\Exchange;

/**
 * Interface PairInterface
 * @package Calculation\Utlis\Exchange
 */
interface PairInterface
{
    /**
     * @return float
     */
    public function getInPercent(): float;

    /**
     * @return float
     */
    public function getOutPercent(): float;

    /**
     * @return PairComponentInterface
     */
    public function getInObject(): PairComponentInterface;

    /**
     * @return PairComponentInterface
     */
    public function getOutObject(): PairComponentInterface;
}
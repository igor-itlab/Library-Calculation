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
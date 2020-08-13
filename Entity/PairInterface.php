<?php


namespace Calculation\Entity;


/**
 * Interface PairInterface
 * @package Calculation\Entity
 */
interface PairInterface
{
    /**
     * @return float
     */
    public function getPercentPayin(): float;

    /**
     * @return float
     */
    public function getPercentPayout(): float;

    /**
     * @return PairUnitInterface
     */
    public function getPayinObject(): PairUnitInterface;

    /**
     * @return PairUnitInterface
     */
    public function getPayoutObject(): PairUnitInterface;

    /**
     * @return string
     */
    public function getState(): string;
}
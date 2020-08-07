<?php


namespace Calculation\Entity;


interface ProviderCommissionInterface
{
    /**
     * @return string
     */
    public function getPercent(): string;

    /**
     * @return string
     */
    public function getConstant(): string;

    /**
     * @return float
     */
    public function getMinContribution(): float;

    /**
     * @return float
     */
    public function getMaxContribution(): float;

    /**
     * @return string
     */
    public function exchangeType(): string;
}
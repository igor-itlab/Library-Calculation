<?php


namespace Calculation\Entity;


interface ProviderFeeInterface
{
    /**
     * @return float
     */
    public function getPercent(): float;

    /**
     * @return float
     */
    public function getConstant(): float;

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
<?php


namespace Calculation;


interface ChangeConfigInterface
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
    public function getCourse(): float;

    /**
     * @return float
     */
    public function getMinContribution(): float;

    /**
     * @return float
     */
    public function getMaxContribution(): float;
}
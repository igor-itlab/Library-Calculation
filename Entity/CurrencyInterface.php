<?php


namespace Calculation\Entity;


interface CurrencyInterface
{
    /**
     * @return string
     */
    public function getAbbreviation(): string;

    /**
     * @return float
     */
    public function getCourse(): float;

    /**
     * @return float
     */
    public function getCoursePayin(): float;

    /**
     * @return float
     */
    public function getCoursePayout(): float;
}
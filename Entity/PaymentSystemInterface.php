<?php


namespace Calculation\Entity;


/**
 * Interface PaymentSystemInterface
 * @package Calculation\Entity
 */
interface PaymentSystemInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getTag(): string;

    public function getCostPrice(): float;
}
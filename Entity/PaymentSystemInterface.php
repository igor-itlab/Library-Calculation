<?php


namespace Calculation\Entity;


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
}
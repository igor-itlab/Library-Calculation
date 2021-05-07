<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface PaymentSystemInterface
 * @package Calculation\Utils\Exchange
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

    /**
     * @return string
     */
    public function getSubName(): string;
}
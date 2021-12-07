<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface PaymentSystemInterface
 * @package Calculation\Utils\Exchange
 */
interface PaymentSystemInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return string|null
     */
    public function getTag(): ?string;

    /**
     * @return string|null
     */
    public function getSubName(): ?string;
}
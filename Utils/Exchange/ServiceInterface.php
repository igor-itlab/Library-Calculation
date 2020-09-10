<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface ServiceInterface
 * @package Calculation\Utils\Exchange
 */
interface ServiceInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getInFee(): array;

    /**
     * @return array
     */
    public function getOutFee(): array;
}
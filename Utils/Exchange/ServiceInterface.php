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
    public function inFee(): array;

    /**
     * @return array
     */
    public function outFee(): array;
}
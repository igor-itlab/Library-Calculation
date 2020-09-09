<?php

namespace Calculation\Utlis\Exchange;

/**
 * Interface ServiceInterface
 * @package Calculation\Utlis\Exchange
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
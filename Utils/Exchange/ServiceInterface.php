<?php

namespace Calculation\Utils\Exchange;

use Ramsey\Uuid\UuidInterface;

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
     * @return string
     */
    public function getTag(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return UuidInterface
     */
    public function getConnection(): UuidInterface;

    /**
     * @return UuidInterface
     */
    public function getServiceId(): UuidInterface;
}

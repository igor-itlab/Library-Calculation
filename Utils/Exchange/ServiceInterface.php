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
    public function getTitle(): ?string;

    /**
     * @return UuidInterface|null
     */
    public function getConnection(): ?UuidInterface;

    /**
     * @return UuidInterface|null
     */
    public function getServiceId(): ?UuidInterface;
}

<?php


namespace Calculation\Entity;


/**
 * Interface ProviderInterface
 * @package Calculation\Entity
 */
interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getPercent(): array;

    /**
     * @return array
     */
    public function getConstant(): array;

    /**
     * @return array
     */
    public function getMinContribution(): array;

    /**
     * @return array
     */
    public function getMaxContribution(): array;
}
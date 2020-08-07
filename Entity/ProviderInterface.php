<?php


namespace Calculation\Entity;


interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;
}
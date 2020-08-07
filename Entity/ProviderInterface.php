<?php


namespace Calculation\Entity;



use Doctrine\Common\Collections\Collection;

interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return ProviderFeeInterface
     */
    public function getProviderCommission(): ProviderFeeInterface;
}
<?php


namespace Calculation\Entity;



use Doctrine\Common\Collections\Collection;

interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;
    public function getProviderCommission(): Collection;
}
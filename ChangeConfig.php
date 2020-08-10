<?php


namespace Calculation;


use Calculation\Entity\ProviderFeeInterface;

class ChangeConfig implements ChangeConfigInterface
{
    /**
     * @var ProviderFeeInterface
     */
    protected ProviderFeeInterface $fee;
    /**
     * @var float
     */
    protected float $course;

    /**
     * ChangeConfig constructor.
     * @param ProviderFeeInterface $fee
     * @param float $course
     */
    public function __construct(
        ProviderFeeInterface $fee,
        float $course
    )
    {
        $this->fee = $fee;
        $this->course = $course;
    }

    /**
     * @return float
     */
    public function getPercent(): float
    {
        return $this->fee->getPercent();
    }

    /**
     * @return float
     */
    public function getConstant(): float
    {
        return $this->fee->getConstant();
    }

    /**
     * @return float
     */
    public function getCourse(): float
    {
        return $this->course;
    }

    /**
     * @return float
     */
    public function getMinContribution(): float
    {
        return $this->fee->getMinContribution();
    }

    /**
     * @return float
     */
    public function getMaxContribution(): float
    {
        return $this->fee->getMaxContribution();
    }
}
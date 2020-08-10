<?php


namespace Calculation;


use Calculation\Entity\PaymentSystemInterface;
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
     * @var PaymentSystemInterface
     */
    protected PaymentSystemInterface $paymentSystem;

    /**
     * ChangeConfig constructor.
     * @param ProviderFeeInterface $fee
     * @param PaymentSystemInterface $paymentSystem
     * @param float $course
     */
    public function __construct(
        ProviderFeeInterface $fee,
        PaymentSystemInterface $paymentSystem,
        float $course
    )
    {
        $this->fee = $fee;
        $this->course = $course;
    }

    public function getPercent(): float
    {
        return $this->fee->getPercent();
    }

    public function getConstant(): float
    {
        return $this->fee->getConstant();
    }

    public function getCourse(): float
    {
        return $this->course;
    }

    public function getPaymentSystem(): PaymentSystemInterface
    {
        return $this->paymentSystem;
    }
}
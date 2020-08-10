<?php


namespace Calculation;


use Calculation\Entity\PaymentSystemInterface;
use Calculation\Entity\ProviderFeeInterface;

interface ChangeConfigInterface
{
    public function getPercent(): float;

    public function getConstant(): float;

    public function getCourse(): float;

    public function getPaymentSystem(): PaymentSystemInterface;

}
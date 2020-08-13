<?php


namespace Calculation;


use Calculation\Entity\PairInterface;


/**
 * Class Payin
 * @package Calculation
 */
class Payin extends CalculationState
{
    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float payin with system commission
     */
    public static function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
        $payoutWithCommission = $count - ($count * $pair->getPayinObject()->getProvider()->getPercent()['inFee'])
            / 100 - $pair->getPayinObject()->getProvider()->getConstant()['inFee'];
        $payinReceivedByCourse = $payoutWithCommission / Course::calculateCourse($pair);
        $onChangeValue = $payinReceivedByCourse * (1 - $pair->getPayoutObject()->getProvider()->getPercent()['outFee'] / 100)
            - $pair->getPayoutObject()->getProvider()->getConstant()['outFee'];
        $pair->getPayinObject()->setOnChangeValue($onChangeValue);

        return $onChangeValue;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMinValue(PairInterface $pair): void
    {
        $payoutMin = $pair->getPayoutObject()->getProvider()->getMinContribution()['inFee'];
        $payinMin = $pair->getPayinObject()->getProvider()->getMinContribution()['inFee'];

        $onChangeValue = Payout::calculateOnChangeValue($payoutMin, $pair);

        if ($payinMin < $onChangeValue) {
            $pair->getPayinObject()->setMinExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMinExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        } else {
            $pair->getPayinObject()->setMinExchangeLimit(ceil($payinMin));
            $pair->getPayoutObject()->setMinExchangeLimit(self::calculateOnChangeValue(ceil($payinMin), $pair));
        }
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMaxValue(PairInterface $pair): void
    {
        $payoutMax = $pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'];
        $payinMax = $pair->getPayinObject()->getProvider()->getMaxContribution()['inFee'];

        $onChangeValue = Payout::calculateOnChangeValue($payoutMax, $pair);

        if ($payinMax < $onChangeValue) {
            $payin = ceil($payinMax);
            $pair->getPayinObject()->setMaxExchangeLimit($payin);
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($payin), $pair));
        } else {
            $pair->getPayinObject()->setMaxExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        }
    }
}

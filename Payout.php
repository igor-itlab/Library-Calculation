<?php


namespace Calculation;


use Calculation\Entity\PairInterface;


/**
 * Class Payout
 * @package Calculation
 */
class Payout extends CalculationState
{
    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
        $payinWithCommission = ($count + $pair->getPayoutObject()->getProvider()->getConstant()['outFee']) /
            (1 - $pair->getPayoutObject()->getProvider()->getPercent()['outFee'] / 100);
        $payoutReceivedByCourse = Course::calculateCourse($pair) * $payinWithCommission;
        $onChangeValue = ($payoutReceivedByCourse + $pair->getPayinObject()->getProvider()->getConstant()['inFee'])
            / (1 - $pair->getPayinObject()->getProvider()->getPercent()['inFee']);
        $pair->getPayoutObject()->setOnChangeValue($onChangeValue);

        return $onChangeValue;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMinValue(PairInterface $pair): void
    {
        $payinMin = $pair->getPayinObject()->getProvider()->getMinContribution()['outFee'];
        $payoutMin = $pair->getPayoutObject()->getProvider()->getMinContribution()['outFee'];

        $onChangeValue = Payin::calculateOnChangeValue($payinMin, $pair);

        if ($payoutMin < $onChangeValue) {
            $pair->getPayinObject()->setMinExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMinExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        } else {
            $pair->getPayinObject()->setMinExchangeLimit(ceil($payoutMin));
            $pair->getPayoutObject()->setMinExchangeLimit(self::calculateOnChangeValue(ceil($payoutMin), $pair));
        }
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMaxValue(PairInterface $pair): void
    {
        $payinMax = $pair->getPayinObject()->getProvider()->getMaxContribution()['outFee'];
        $payoutMax = $pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'];

        $onChangeValue = Payin::calculateOnChangeValue($payinMax, $pair);

        if ($payoutMax < $onChangeValue) {
            $payin = ceil($payoutMax);
            $pair->getPayinObject()->setMaxExchangeLimit($payin);
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($payin), $pair));
        } else {
            $pair->getPayinObject()->setMaxExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        }
    }
}
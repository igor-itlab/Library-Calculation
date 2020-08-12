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
        $payinValue = ($count + $pair->getPayoutObject()->getProvider()->getConstant()['outFee']) /
            (1 - $pair->getPayoutObject()->getProvider()->getPercent()['outFee'] / 100);
        $payoutValue = Course::calculateCourse($pair) * $payinValue;
        $onChangeValue = ($payoutValue + $pair->getPayinObject()->getProvider()->getConstant()['inFee'])
            / (1 - $pair->getPayinObject()->getProvider()->getPercent()['inFee']);
        $pair->getPayoutObject()->setOnChangeValue($onChangeValue);

        return $onChangeValue;
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMinValue(PairInterface $pair): void
    {
        $onChangeValue = Payin::calculateOnChangeValue(
            $pair->getPayinObject()->getProvider()->getMinContribution()['outFee'],
            $pair
        );

        if ($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee'] < $onChangeValue) {
            $pair->getPayinObject()->setMinExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMinExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        } else {
            $pair->getPayinObject()->setMinExchangeLimit(
                ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee'])
            );
            $pair->getPayoutObject()->setMinExchangeLimit(
                self::calculateOnChangeValue(
                    ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee']),
                    $pair
                )
            );
        }
    }

    /**
     * @param PairInterface $pair
     */
    public static function calculateMaxValue(PairInterface $pair): void
    {
        $onChangeValue = Payin::calculateOnChangeValue(
            $pair->getPayinObject()->getProvider()->getMaxContribution()['outFee'],
            $pair
        );

        if ($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'] < $onChangeValue) {
            $payin = ceil($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee']);
            $pair->getPayinObject()->setMaxExchangeLimit($payin);
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($payin), $pair));
        } else {
            $pair->getPayinObject()->setMaxExchangeLimit(ceil($onChangeValue));
            $pair->getPayoutObject()->setMaxExchangeLimit(self::calculateOnChangeValue(ceil($onChangeValue), $pair));
        }
    }
}
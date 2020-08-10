<?php


namespace Calculation;


use Calculation\Entity\PairInterface;

/**
 * Class Payout
 * @package Calculation
 */
class Payout implements CalculationInterface
{
    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    static public function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
        $payinValue = ($count + $pair->getPayoutObject()->getProvider()->getConstant()['outFee']) /
            (1 - $pair->getPayoutObject()->getProvider()->getPercent()['outFee'] / 100);
        $payoutValue = Course::calculateCourse($pair) * $payinValue;

        return ($payoutValue + $pair->getPayinObject()->getProvider()->getConstant()['inFee'])
            / (1 - $pair->getPayinObject()->getProvider()->getPercent()['inFee']);
    }

    /**
     * @param PairInterface $pair
     * @return false|float|string
     */
    static public function calculateMinValue(PairInterface $pair)
    {
        $onChangeValue = Payin::calculateOnChangeValue($pair->getPayinObject()->getProvider()->getMinContribution()['outFee'], $pair);

        if ($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee'] < $onChangeValue) {
            $minPayin = ceil($onChangeValue);
            $minPayout = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        } else {
            $minPayin = ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee']);
            $minPayout = self::calculateOnChangeValue(ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee']), $pair);
        }

        return json_encode(['minPayin' => $minPayin, 'minPayout' => $minPayout]);
    }

    /**
     * @param PairInterface $pair
     * @return false|float|string
     */
    static public function calculateMaxValue(PairInterface $pair)
    {
        $onChangeValue = Payin::calculateOnChangeValue($pair->getPayinObject()->getProvider()->getMaxContribution()['outFee'], $pair);

        if ($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'] < $onChangeValue) {
            $maxPayin = ceil($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee']);
            $maxPayout = self::calculateOnChangeValue(ceil($maxPayin), $pair);
        } else {
            $maxPayin = ceil($onChangeValue);
            $maxPayout = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        }

        return json_encode(['maxPayin' => $maxPayin, 'maxPayout' => $maxPayout]);
    }
}
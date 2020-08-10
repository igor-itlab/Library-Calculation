<?php


namespace Calculation;


use Calculation\Entity\PairInterface;

/**
 * Class Payout
 * @package Calculation
 */
class Payout extends CalculationState implements CalculationInterface
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

        return ($payoutValue + $pair->getPayinObject()->getProvider()->getConstant()['inFee'])
            / (1 - $pair->getPayinObject()->getProvider()->getPercent()['inFee']);
    }

    /**
     * @param PairInterface $pair
     * @return false|string
     * @throws \JsonException
     */
    public static function calculateMinValue(PairInterface $pair)
    {
        $onChangeValue = Payin::calculateOnChangeValue($pair->getPayinObject()->getProvider()->getMinContribution()['outFee'], $pair);

        if ($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee'] < $onChangeValue) {
            $minPayin = ceil($onChangeValue);
            $minPayout = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        } else {
            $minPayin = ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee']);
            $minPayout = self::calculateOnChangeValue(ceil($pair->getPayoutObject()->getProvider()->getMinContribution()['outFee']), $pair);
        }

        return json_encode(['minPayin' => $minPayin, 'minPayout' => $minPayout], JSON_THROW_ON_ERROR);
    }

    /**
     * @param PairInterface $pair
     * @return false|string
     * @throws \JsonException
     */
    public static function calculateMaxValue(PairInterface $pair)
    {
        $onChangeValue = Payin::calculateOnChangeValue($pair->getPayinObject()->getProvider()->getMaxContribution()['outFee'], $pair);

        if ($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'] < $onChangeValue) {
            $maxPayin = ceil($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee']);
            $maxPayout = self::calculateOnChangeValue(ceil($maxPayin), $pair);
        } else {
            $maxPayin = ceil($onChangeValue);
            $maxPayout = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        }

        return json_encode(['maxPayin' => $maxPayin, 'maxPayout' => $maxPayout], JSON_THROW_ON_ERROR);
    }
}
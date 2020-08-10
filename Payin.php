<?php


namespace Calculation;


use Calculation\Entity\PairInterface;


/**
 * Class Payin
 * @package Calculation
 */
class Payin implements CalculationInterface
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

        return $payinReceivedByCourse * (1 - $pair->getPayoutObject()->getProvider()->getPercent()['outFee'] / 100)
            - $pair->getPayoutObject()->getProvider()->getConstant()['outFee'];
    }

    /**
     * @param PairInterface $pair
     * @return float|void
     */
    public static function calculateMinValue(PairInterface $pair)
    {
        $onChangeValue = Payout::calculateOnChangeValue($pair->getPayoutObject()->getProvider()->getMinContribution()['inFee'], $pair);

        if ($pair->getPayinObject()->getProvider()->getMinContribution()['inFee'] < $onChangeValue) {
            $minPayout = ceil($onChangeValue);
            $minPayin = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        } else {
            $minPayout = ceil($pair->getPayinObject()->getProvider()->getMinContribution()['inFee']);
            $minPayin = self::calculateOnChangeValue(ceil($pair->getPayinObject()->getProvider()->getMinContribution()['inFee']), $pair);
        }

        return json_encode(['minPayin' => $minPayin, 'minPayout' => $minPayout]);
    }

    /**
     * @param PairInterface $pair
     * @return float|void
     */
    public static function calculateMaxValue(PairInterface $pair)
    {
        $onChangeValue = Payin::calculateOnChangeValue($pair->getPayoutObject()->getProvider()->getMaxContribution()['outFee'], $pair);

        if ($pair->getPayinObject()->getProvider()->getMaxContribution()['inFee'] < $onChangeValue) {
            $maxPayout = ceil($pair->getPayinObject()->getProvider()->getMaxContribution()['inFee']);
            $maxPayin = self::calculateOnChangeValue(ceil($maxPayout), $pair);
        } else {
            $maxPayout = ceil($onChangeValue);
            $maxPayin = self::calculateOnChangeValue(ceil($onChangeValue), $pair);
        }

        return json_encode(['maxPayin' => $maxPayin, 'maxPayout' => $maxPayout]);
    }
}

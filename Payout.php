<?php


namespace Calculation;


class Payout implements CalculationInterface
{
    /**
     * @param float $count
     * @param ChangeConfigInterface $payin
     * @param ChangeConfigInterface $payout
     * @return float
     */
    public function calculateOnChangeValue(
        float $count,
        ChangeConfigInterface $payin,
        ChangeConfigInterface $payout
    ): float {
        return (($count + $payout->getConstant()) / (1 - $payout->getPercent() / 100) * $course + $payin->getConstant(
                )) / (1 - $payin->getPercent() / 100);
    }

    /**
     * @param ChangeConfigInterface $payin
     * @param ChangeConfigInterface $payout
     * @return array
     */
    public function calculateMinValue(
        ChangeConfigInterface $payin,
        ChangeConfigInterface $payout
    ): array {
        $min = array();
        $changeValue = $this->calculateOnChangeValue($payout->getMinContribution(), $payin, $payout);

        if ($payin->getMinContribution() < $changeValue) {
            $min = [
                'minPayin'  => ceil($changeValue),
                'minPayout' => $this->calculateOnChangeValue(ceil($changeValue), $payin, $payout)
            ];
        }

        return $min;
    }

    /**
     * @param ChangeConfigInterface $payin
     * @param ChangeConfigInterface $payout
     * @return array
     */
    public function calculateMaxValue(
        ChangeConfigInterface $payin,
        ChangeConfigInterface $payout
    ): array {
        $max = array();
        $changeValue = $this->calculateOnChangeValue($payout->getMaxContribution(), $payin, $payout);
    }
}
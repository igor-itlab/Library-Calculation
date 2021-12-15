<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface CourseInterface
 * @package Calculation\Utils\Calculation
 */
interface CourseInterface
{
    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculate(PairInterface $pair, float $percent = null): float;

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculateLastFee(PairInterface $pair, float $percent = null): float;

    /**
     * @param PairInterface $pair
     * @param float|null $percent
     * @return float
     */
    public static function calculateSurcharge(PairInterface $pair, float $percent = null): float;

    /**
     * @param string $tag
     * @param float $rate
     * @param string $asset
     * @return float
     */
    public static function getRate(string $tag, float $rate, string $asset): float;
}
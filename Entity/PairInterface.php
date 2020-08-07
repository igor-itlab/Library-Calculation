<?php


namespace Calculation\Entity;


interface PairInterface
{
    public function getPercentPayin(): float;
    public function getPercentPayout(): float;
}
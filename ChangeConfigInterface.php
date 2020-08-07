<?php


namespace Calculation;


interface ChangeConfigInterface
{
    public function getPercent(): float;

    public function getConstant(): float;

    public function getCourse(): float;
}
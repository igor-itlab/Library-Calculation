<?php


namespace Calculation\Service;


use Calculation\Payin;
use Calculation\Payout;
use stdClass;

class Converter
{
    /**
     * @param string $type
     * @return mixed
     */
    public static function toObject(string $type)
    {
        $type = ucfirst(strtolower($type));
        return self::getType()->$type;
    }

    /**
     * @return stdClass
     */
    public static function getType(): stdClass
    {
        $list = new stdClass();

        $list->Payin = new Payin();
        $list->Payout = new Payout();

        return $list;
    }

    /**
     * @param string $type
     * @return Payin|Payout
     */
    public static function getInvertedObject(string $type)
    {
        if (self::toObject($type) instanceof Payin) { return new Payout(); }

        return new Payin();
    }
}
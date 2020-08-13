<?php


namespace Calculation\Service;


use Calculation\Payin;
use Calculation\Payout;
use ReflectionClass;
use ReflectionException;
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
     * @param Payin|Payout $object
     * @return string
     * @throws ReflectionException
     */
    public function toString($object): string
    {
        return strtolower((new ReflectionClass($object))->getShortName());
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
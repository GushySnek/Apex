<?php


namespace App\Entity\Constant;


class FireModes
{
    public const SINGLE = "Single";
    public const AUTO = "Auto";


    public static function values() {
        return [
            self::SINGLE,
            self::AUTO,
        ];
    }

    public static function formValues() {
        $formValues = [];
        foreach (self::values() as $value) {
            $formValues[$value] = $value;
        }

        return $formValues;
    }
}
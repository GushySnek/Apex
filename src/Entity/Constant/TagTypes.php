<?php


namespace App\Entity\Constant;


class TagTypes
{
    public const WEAPONS = "weapons";
    public const HEROES = "heroes";
    public const NEWS = "news";


    public static function values() {
        return [
            self::WEAPONS,
            self::HEROES,
            self::NEWS
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
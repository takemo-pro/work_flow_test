<?php

namespace Requests;

require_once "Validatable.php";

class CustomerType extends BaseEnum implements Validatable
{
    public const ADULT="0";
    public const CHILD="1";
    public const SENIOR="2";

    public static function getLocalizedArray(): array
    {
        $result = [];
        foreach(self::getKeyValues() as $key => $val){
            $result[match($key){
                "ADULT" => "大人",
                "CHILD" => "子供",
                "SENIOR" => "シニア",
                default => throw new \UnexpectedValueException("プログラムに無効な値が設定されています($key)"),
            }] = $val;
        }
        return $result;
    }
}
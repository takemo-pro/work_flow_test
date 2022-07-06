<?php

namespace Requests;

require_once "Validatable.php";

/**
 * Enumベースのルールクラス
 */
abstract class BaseEnum implements Validatable
{
    public static function getKeyValues(): array
    {
        return (new \ReflectionClass(static::class))->getConstants();
    }

    public static function validate($value) :bool
    {
        foreach(static::getKeyValues() as $constant){
            if($constant === $value){
                return true;
            }
        }
        return false;
    }
}

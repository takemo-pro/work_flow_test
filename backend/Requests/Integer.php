<?php

namespace Requests;

class Integer implements Validatable
{
    public static function validate($value): bool
    {
        return is_numeric($value) && is_integer((integer) $value);
    }
}

<?php

namespace Requests;

interface Validatable
{
    public static function validate($value) :bool;
}

<?php

namespace Requests;

require_once "Validatable.php";

class PriceType extends BaseEnum implements Validatable
{
    public const NORMAL = "0";
    public const SPECIAL = "1";
}

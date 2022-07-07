<?php

require_once "./Requests/CustomerType.php";
require_once "./Requests/PriceType.php";

return [
    \Requests\CustomerType::ADULT => [
        \Requests\PriceType::NORMAL => 1000,
        \Requests\PriceType::SPECIAL => 600,
    ],
    \Requests\CustomerType::CHILD => [
        \Requests\PriceType::NORMAL => 500,
        \Requests\PriceType::SPECIAL => 400,
    ],
    \Requests\CustomerType::SENIOR => [
        \Requests\PriceType::NORMAL => 800,
        \Requests\PriceType::SPECIAL => 500,
    ],
];

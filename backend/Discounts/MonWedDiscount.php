<?php

namespace Discounts;


use Request;

/**
 * 月水割引ルール
 *
 * note:
 *  月水は100円割引とする
 */
class MonWedDiscount extends \BaseDiscount
{
    /** @var string 割引名 */
    protected static string $name = "月水割引";

    /** @var string 割引タイプ */
    protected static string $discountType = \DiscountType::AMOUNT;

    /** @var int|float 割引額 or 割引率 */
    protected static int|float $amount = 100;

    public function canDiscount(int $value) :bool
    {
        //https://www.php.net/manual/ja/datetime.format.php
        $dayOfWeek = (int) $this->request->getDateTime()->format("N");
        return $dayOfWeek === 1 || $dayOfWeek === 3;
    }
}
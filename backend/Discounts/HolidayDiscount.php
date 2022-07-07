<?php

namespace Discounts;


use Request;

/**
 * 休日割増ルール
 *
 * note:
 *  休日(土日)は200増しとする
 *  祝日は考慮していない。(する場合はGoogleCalendarあたりと連携)
 */
class HolidayDiscount extends \BaseDiscount
{
    /** @var string 割引名 */
    protected static string $name = "休日料金";

    /** @var string 割引タイプ */
    protected static string $discountType = \DiscountType::AMOUNT;

    /** @var int|float 割引額 or 割引率 */
    protected static int|float $amount = -200;

    public function canDiscount(int $value) :bool
    {
        //https://www.php.net/manual/ja/datetime.format.php
        $dayOfWeek = (int) $this->request->getDateTime()->format("N");
        return $dayOfWeek >= 6;
    }
}
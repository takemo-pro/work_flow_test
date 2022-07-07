<?php

namespace Discounts;

require_once "BaseDiscount.php";

use Request;

/**
 * 夕方割引ルール
 *
 * note:
 *  夕方17時以降なら100円の定額割引
 *  現状は17~24時を割引対象としている
 */
class EveningDiscount extends \BaseDiscount
{
    /** @var string 割引名 */
    protected static string $name = "夕方割引";

    /** @var string 割引タイプ */
    protected static string $discountType = \DiscountType::AMOUNT;

    /** @var int|float 割引額 or 割引率 */
    protected static int|float $amount = 100;

    public function canDiscount(int $value) :bool
    {
        $nowHour = (int) $this->request->getDateTime()->format("G");
        return $nowHour >= 17;
    }
}
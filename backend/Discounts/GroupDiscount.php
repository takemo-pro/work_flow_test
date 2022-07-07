<?php

namespace Discounts;


use Request;

/**
 * 団体割引ルール
 *
 * note: 団体合計で10人以上の場合10%の定率割引
 */
class GroupDiscount extends \BaseDiscount
{
    /** @var string 割引名 */
    protected static string $name = "団体割引";

    /** @var string 割引タイプ */
    protected static string $discountType = \DiscountType::RATE;

    /** @var int|float 割引額 or 割引率 */
    protected static int|float $amount = 0.1;

    /** @var Request リクエスト */
    private Request $request;

    public function canDiscount(int $value) :bool
    {
        return count($this->request->getCustomers()) >= 10;
    }
}
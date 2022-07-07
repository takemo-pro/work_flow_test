<?php

require_once "./Request.php";
require_once "./Discountable.php";
require_once "./Discounts/EveningDiscount.php";
require_once "./Discounts/HolidayDiscount.php";
require_once "./Discounts/MonWedDiscount.php";
require_once "./DiscountType.php";

//note: 1人割引は未考慮、1顧客種類への割引は考慮
class CustomerUnit
{
    use Discountable;
    /** @var string 金額のタイプ(通常/特別など) */
    private string $priceType;

    /** @var string 顧客タイプ(大人・子供など) */
    private string $customerType;

    /** @var BaseDiscount[] 割引ルール */
    private static array $discountRuleClasses = [
        \Discounts\EveningDiscount::class,
        \Discounts\HolidayDiscount::class,
        \Discounts\MonWedDiscount::class,
    ];

    /**
     * @param string $priceType
     * @param string $customerType
     */
    public function __construct(string $priceType, string $customerType)
    {
        $this->priceType = $priceType;
        $this->customerType = $customerType;
    }

    /**
     * 割引前金額取得
     * @return int
     */
    public function getBasePrice() :int
    {
        $priceMaster = require "./price_table.php";
        return $priceMaster[$this->customerType][$this->priceType];
    }

    /**
     * 割引後合計金額取得
     */
    public function getTotalPrice(Request $request) :int
    {
        return $this->getBasePrice() - $this->getDiscountPrice();
    }

    /**
     * 割引の計算、保存
     * @param Request $request
     */
    public function processDiscount(Request $request){
        /** @var BaseDiscount $discountRuleClass */
        foreach(self::$discountRuleClasses as $discountRuleClass){
            $this->createDiscountDetail(new $discountRuleClass($request));
        }
    }
}
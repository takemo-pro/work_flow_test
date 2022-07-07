<?php

require_once "./Request.php";

//note: 1人割引は未考慮、1顧客種類への割引は考慮
class CustomerUnit
{
    /** @var int 割引前金額(特別割引は含まない) */
    private int $basePrice;
    public function getBasePrice() :int
    {
        return $this->basePrice;
    }

    /** @var string 金額のタイプ(通常/特別など) */
    private string $priceType;
    public function getPriceType() :string
    {
        return $this->basePrice;
    }


    /** @var string 顧客タイプ(大人・子供など) */
    private string $customerType;
    public function getCustomerType() :string
    {
        return $this->customerType;
    }

    /** @var Request 入力値 note: 夕方のみ購入者1人だけ割引と言ったニーズで利用することを想定 */
    private Request $request;

    /** @var array 割引明細 */
    private array $discountDetails = [];

    /** @var array 割引ルール */
    private static array $discountRuleClasses = [
        \Discounts\EveningDiscount::class,
        \Discounts\HolidayDiscount::class,
        \Discounts\MonWedDiscount::class,
    ];

    /**
     * @param string $priceType
     * @param string $customerType
     * @param int $basePrice
     * @param Request $request
     */
    public function __construct(string $priceType, string $customerType,int $basePrice,Request $request)
    {
        $this->basePrice = $basePrice;
        $this->priceType = $priceType;
        $this->customerType = $customerType;
        $this->request = $request;
    }

    /**
     * 割引後合計金額取得
     */
    public function getTotalPrice(int $basePrice) :int
    {
        return $basePrice - $this->getDiscountPrice($basePrice);
    }

    /**
     * 割引金額取得
     */
    public function getDiscountPrice(int $basePrice) :int
    {
        $discountPrice = 0;
        foreach(self::$discountRuleClasses as $ruleClass){
            /** @var BaseDiscount $ruleObject */
            $ruleObject = new $ruleClass($this->request);
            if($ruleObject->canDiscount($this->basePrice)){
                if($ruleObject::getDiscountType() === DiscountType::AMOUNT){
                    $discountPrice += $ruleObject::getAmount();
                }else{
                    $discountPrice += $basePrice * $ruleObject::getAmount();
                }
            }
        }
        return (int) floor($discountPrice);
    }
}
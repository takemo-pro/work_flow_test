<?php

require_once "./Request.php";
require_once "./Discountable.php";
require_once "./Discounts/GroupDiscount.php";

class Customers implements Countable
{
    use Discountable;

    /** @var CustomerUnit[] */
    private array $customerUnits;
    public function getCustomerUnits(): array
    {
        return $this->customerUnits;
    }

    public function count(): int
    {
        return count($this->customerUnits);
    }

    /** @return int 割引前金額(特別割引は含まない) */
    public function getBasePrice() :int
    {
        $basePrice = 0;
        foreach($this->customerUnits as $customerUnit){
            $basePrice += $customerUnit->getBasePrice();
        }
        return $basePrice;
    }

    /** @var array 割引ルール */
    private static array $discountRuleClasses = [
        \Discounts\GroupDiscount::class
    ];

    /**
     * @param array $customerUnits
     */
    public function __construct(array $customerUnits)
    {
        $this->customerUnits = $customerUnits;
    }

    /**
     * 割引の計算、保存
     * @param Request $request
     */
    public function processDiscount(Request $request)
    {
        foreach($this->customerUnits as $customerUnit){
            $customerUnit->processDiscount($request);
        }
        foreach(self::$discountRuleClasses as $discountRuleClass){
            $this->createDiscountDetail(new $discountRuleClass($request));
        }
    }
}
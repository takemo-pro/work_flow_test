<?php

require_once "./Request.php";
require_once "./DiscountDetail.php";

//fixme: use側 getBasePriceの実装に依存している -> 引数を持たせた方が良いか？ or interfaceを継承させるか
trait Discountable
{
    /** @var array 割引明細 */
    private array $discountDetails = [];

    /**
     * @return DiscountDetail[]
     */
    public function getDiscountDetails(): array
    {
        return $this->discountDetails;
    }

    private function createDiscountDetail(BaseDiscount $ruleObject)
    {
        if($ruleObject->canDiscount($this->getBasePrice())){
            if($ruleObject::getDiscountType() === DiscountType::AMOUNT){
                //定額
                $this->discountDetails[] = new DiscountDetail(
                    discountName: $ruleObject::getName(),
                    discountPrice: $ruleObject::getAmount()
                );
            }else{
                //定率
                $this->discountDetails[] = new DiscountDetail(
                    discountName: $ruleObject::getName(),
                    discountPrice: $this->getBasePrice() * $ruleObject::getAmount()
                );
            }
        }
    }

    /**
     * 合計割引額の取得
     *
     * @return int
     */
    public function getDiscountPrice(): int
    {
        $discountPrice = 0;
        /** @var DiscountDetail $discountDetail */
        foreach($this->discountDetails as $discountDetail) {
            $discountPrice += $discountDetail->getDiscountPrice();
        }
        foreach($this->getCustomerUnits() as $customerUnit)
        {
            foreach($customerUnit->getDiscountDetails() as $discountDetail){
                $discountPrice += $discountDetail->getDiscountPrice();
            }
        }
        return $discountPrice;
    }

    /**
     * 合計金額の取得
     *
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->getBasePrice() - $this->getDiscountPrice();
    }
}
<?php

/**
 * 出力内容を定義
 */
class Response
{
    /** @var Customers  */
    private Customers $customers;


    public function __construct(Customers $customers)
    {
        $this->customers = $customers;
    }

    public function render()
    {
        echo "割引前合計金額=============================================".PHP_EOL;
        echo $this->customers->getBasePrice() . "円" . PHP_EOL;
        echo "割引割増合計金額===============================================".PHP_EOL;
        echo -1 * $this->customers->getDiscountPrice() . "円" . PHP_EOL;
        echo "割引割増明細==================================================".PHP_EOL;
        $this->renderDiscountDetails();
        echo "合計金額==================================================".PHP_EOL;
        echo $this->customers->getTotalPrice() . "円" . PHP_EOL;
    }

    /**
     * 割引明細の整形、表示
     */
    private function renderDiscountDetails()
    {
        $parentDiscountDetails = $this->customers->getDiscountDetails();
        $childDiscountDetails = [];
        foreach($this->customers->getCustomerUnits() as $customerUnit){
            $childDiscountDetails = array_merge($childDiscountDetails,$customerUnit->getDiscountDetails());
        }
        $discountDetails = array_merge($parentDiscountDetails,$childDiscountDetails);

        $result = [];
        /** @var DiscountDetail $discountDetail */
        foreach($discountDetails as $discountDetail){
            if(isset($result[$discountDetail->getDiscountName()])){
                $result[$discountDetail->getDiscountName()] += $discountDetail->getDiscountPrice();
            }else{
                $result[$discountDetail->getDiscountName()] = $discountDetail->getDiscountPrice();
            }
        }

        foreach($result as $name => $value){
            //割引割増は表記上逆転させる
            echo $name . " : " . (-1*$value) . "円".PHP_EOL;
        }
    }

}
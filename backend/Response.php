<?php

/**
 * 出力内容を定義
 */
class Response
{
    /** @var CustomerUnit[]  */
    public array $customers;

    /**
     * 割引前合計金額を算出
     */
    public function getTotalBasePrice()
    {
        $price = 0;
        foreach($this->customers as $customer)
        {
            $price += $customer->getzb;
        }
    }

    public function __construct(array $customerUnits)
    {
        $this->customers = $customerUnits;
    }

    public function render()
    {
    }
}
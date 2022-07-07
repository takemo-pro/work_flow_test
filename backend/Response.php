<?php

/**
 * 出力内容を定義
 */
class Response
{
    /** @var Customers  */
    public Customers $customers;

    public function __construct(Customers $customers)
    {
        $this->customers = $customers;
    }

    public function render()
    {
        echo "割引前合計金額".PHP_EOL;
        echo $this->customers->getBasePrice() . PHP_EOL;
        echo "割引合計金額".PHP_EOL;
        echo $this->customers->getDiscountPrice() . PHP_EOL;
        echo "合計金額".PHP_EOL;
        echo $this->customers->getTotalPrice() . PHP_EOL;
    }
}
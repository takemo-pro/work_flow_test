<?php

class DiscountDetail
{
    /**
     * @param string $discountName 割引名
     * @param int $discountPrice 割引額
     */
    public function __construct(
        public string $discountName,
        public int $discountPrice,
    ){}

}
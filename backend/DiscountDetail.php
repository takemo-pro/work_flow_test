<?php

class DiscountDetail
{
    /**
     * @param string $discountName 割引名
     * @param int $discountPrice 割引額
     */
    public function __construct(
        private string $discountName,
        private int $discountPrice,
    ){}

    /**
     * @return int
     */
    public function getDiscountPrice(): int
    {
        return $this->discountPrice;
    }

    /**
     * @return string
     */
    public function getDiscountName(): string
    {
        return $this->discountName;
    }

}
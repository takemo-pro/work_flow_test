<?php



abstract class BaseDiscount
{
    /** @var string 割引名 */
    protected static string $name;
    public static function getName() :string{
        return self::$name;
    }

    /** @var string 割引タイプ */
    protected static string $discountType;
    public static function getDiscountType() :string{
        return self::$discountType;
    }

    /** @var int|float 割引額 or 割引率 */
    protected static int|float $amount;
    public static function getAmount() :int|float{
        return self::$amount;
    }

    /** @var Request リクエスト */
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 割引対象かどうか返す
     *
     * @param int $value 基本使わないがベース金額(10000円以上で割引などに対応するため)
     * @return bool
     */
    abstract public function canDiscount(int $value) :bool;
}
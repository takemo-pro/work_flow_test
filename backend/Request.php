<?php

require_once "./Requests/BaseEnum.php";
require_once "./Requests/CustomerType.php";
require_once "./Requests/Integer.php";
require_once "./Requests/PriceType.php";

use Requests\CustomerType;
use Requests\Integer;
use Requests\PriceType;
use Requests\Validatable;

/**
 * note:
 *  - 客層
 *  - 人数(客層に依存)
 *  - 料金タイプ
 *  - 時間
 *  - 日程(休日割,月水割)
 */
class Request
{
    /** @var array 顧客の種類・人数  */
    private array $customers = [];
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /** @var string 料金タイプ */
    private string $priceType;
    public function getPriceType(): string
    {
        return $this->priceType;
    }

    /** @var DateTime 入園日時 */
    private DateTime $datetime;
    public function getDateTime(): DateTime
    {
        return $this->datetime;
    }

    /**
     * 入力を受け取る
     *
     * @return Request
     * @throws InvalidArgumentException
     */
    public static function getInputs(): Request
    {
        $self = new self;
        foreach(CustomerType::getSelectArray() as $name => $value){
            $customerCount = $self->ask("{$name}の人数を設定してください(整数)", Integer::class);
            $self->customers[$value] = $customerCount;
        }

        $self->priceType = $self->ask("通常料金か特別料金か選択してください(通常:0,特別:1)",PriceType::class);

        $self->datetime = new DateTime('now');
        $self->datetime->setTimezone(new DateTimeZone('Asia/Tokyo'));

        return $self;
    }

    /**
     * QA方式で回答を受け取る
     *
     * @param $message
     * @param string|null $validator
     * @return string
     */
    public function ask($message,string $validator = null) :string
    {
        echo $message.PHP_EOL;

        while(true){
            //get parameters
            $stdin = fgets(STDIN);
            if($stdin){
                $input = trim($stdin);
            }else{
                echo "exit;".PHP_EOL;
                exit;
            }

            //validation
            if(is_subclass_of($validator,Validatable::class)) {
                if($validator::validate($input)){
                    return $input;
                }else{
                    echo "入力された値に誤りがあります。再入力してください".PHP_EOL;
                }
            }else{
                return $input;
            }
        }
    }
}
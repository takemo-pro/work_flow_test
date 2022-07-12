<?php

require_once "./Requests/BaseEnum.php";
require_once "./Requests/CustomerType.php";
require_once "./Requests/Integer.php";
require_once "./Requests/AdmissionDatetime.php";
require_once "./Requests/PriceType.php";
require_once "./CustomerUnit.php";
require_once "./Customers.php";

use Requests\CustomerType;
use Requests\Integer;
use Requests\PriceType;
use Requests\Validatable;

class Request
{
    /** @var Customers 顧客の種類・人数  */
    private Customers $customers;
    public function getCustomers() :Customers
    {
        return $this->customers;
    }

    /** @var string 料金タイプ note:全体統一か個別適用か不明だったためRequest,CustomerUnit双方に実装 */
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
     */
    public static function getInputs(): Request
    {
        $self = new self;

        $self->priceType = $self->ask("料金タイプを選択してください(通常:0,特別:1)",PriceType::class);
        $self->setCustomers();

        //note: validatorで日時の検証をしているのでDatetimeコンストラクタの例外は無視可能
        $self->datetime = (new DateTime(
            $self->ask('日時を選択してください(未入力で現在)',\Requests\AdmissionDatetime::class)
        ))->setTimezone(new DateTimeZone('Asia/Tokyo'));

        return $self;
    }

    /**
     * QA方式で回答を受け取る
     *
     * @param $message
     * @param string|null $validator
     * @return string
     */
    private function ask($message,string $validator = null) :string
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

    private function setCustomers()
    {
        //note: price master
        $priceList = require_once "./price_table.php";
        $customers = [];
        foreach(CustomerType::getLocalizedArray() as $label => $customerType){
            $customerCount = $this->ask("{$label}の人数を設定してください(整数)", Integer::class);
            for($i=$customerCount;$i>0;$i--)
            {
                $customers[] = new CustomerUnit(
                    priceType: $this->priceType,
                    customerType: $customerType,
                );
            }
        }
        if(empty($customers)){
            echo "1人も入力されなかったため、処理を終了します".PHP_EOL;
            exit;
        }
        $this->customers = new Customers($customers);
    }
}

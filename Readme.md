# ワークサンプルテスト

## 課題1
### 動作環境
PHP8.0

### 使い方
docker,docker-compose環境で

``` docker-compose run app php index.php ```


### 仕様Q&A(想定回答)

-----------
Q.割引額(定率割引)の計算方法について

A.定率割引(団体割引)はベース金額に対する割合で計算。(割引後金額に適用だと適用順によって金額が変化するため考慮する必要なしと判断)

-----------
Q. 金額計算時の端数の扱いについて

A. 小数点以下切り捨て,個別割引と全体割引でそれぞれ切り捨て

-----------

Q. お客様区分、料金区分は今後増える可能性があるか

A. ある。(増減したらprice_tableとCustomerType,PriceTypeを編集)

-----------

Q. 各割引のそれぞれの割引対象について

A. 団体割引のみ全体適用,他は1人ずつ適用

-----------

Q. 団体の中で個別に通常、特別割が適用されるか

A. されない

-----------

Q. お客様区分ごとの割引(ex.大人だけ割引)はあるか

A. ない(ある場合はCustomersとCustomerUnitの間にCustomerGroupを持たせる)

-----------

Q. 顧客の種類別の割引はあるか (大人だけ、子供だけ)

A. ない

-----------

Q. 割引の適用タイミングはいつか(定率割引)

A. 原価に対して割引を計算し割引金額を合算して適用する

-----------

Q. 課題の必須条件について

A. PHP,PHP_extension以外は導入しない(composerやphpunit,外部パッケージなどは使用しない)

-----------

### テスト結果

[TestResult.md](TestResult.md)にまとめています。

## 課題2
資料はGoogle Docにまとめましたので下記リンクをご覧ください

https://docs.google.com/document/d/1ZkK-9RJ97RzdePY48lyhuRhKZCaUi12lptve0tfQuZ8/edit?usp=sharing

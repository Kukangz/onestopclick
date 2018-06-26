<?php

namespace frontend\components\CashMoney;

use yii\base\Component;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class CashMoney extends Component {
  public $client_id;
  public $client_secret;
  public $apiContext; // paypal's API context

  // override Yii's object init()
  function init() { 
    
  }

  public function getContext() {
    return $this->apiContext;
  }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iyzico_lib {

    public $options;
    public $request;
    public $basketItems;

    public function __construct()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey("");
        $this->options->setSecretKey("");
        $this->options->setBaseUrl("https://api.iyzipay.com");
        $this->basketItems = [];
    }

    public function setSubscriptionFormCreate(Array $params)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionCreateCheckoutFormRequest();
      $this->request->setLocale($params['locale']);
      $this->request->setPricingPlanReferenceCode($params['pricingPlanReferenceCode']);
      $this->request->setSubscriptionInitialStatus($params['status']);
      $this->request->setCallbackUrl($params['callbackUrl']);
      $customer = new \Iyzipay\Model\Customer();
      $customer->setName($params['name']);
      $customer->setSurname($params['surname']);
      $customer->setGsmNumber($params['number']);
      $customer->setEmail($params['email']);
      $customer->setIdentityNumber($params['tc']);
      $customer->setShippingContactName("Adres");
      $customer->setShippingCity($params['city']);
      $customer->setShippingDistrict($params['district']);
      $customer->setShippingCountry($params['country']);
      $customer->setShippingAddress($params['address']);
      $customer->setBillingContactName("Adres");
      $customer->setBillingCity($params['city']);
      $customer->setBillingDistrict($params['district']);
      $customer->setBillingCountry($params['country']);
      $customer->setBillingAddress($params['address']);
      $this->request->setCustomer($customer);
      return \Iyzipay\Model\Subscription\SubscriptionCreateCheckoutForm::create($this->request,$this->options);
      return $this;
     }

     public function retrySubscription(Array $params)
     {
       $this->request = new \Iyzipay\Request\Subscription\SubscriptionRetryRequest();
       $this->request->setLocale("tr");
       // $this->request->setConversationId($params['conversationId']);
       $this->request->setReferenceCode($params['referenceCode']);
       return \Iyzipay\Model\Subscription\SubscriptionRetry::update($this->request,$this->options);
     }


    public function updateCard(Array $params)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionCardUpdateRequest();
      $this->request->setLocale("tr");
      // $this->request->setConversationId("123456789");
      $this->request->setCustomerReferenceCode($params['customerReferenceCode']);
      $this->request->setCallBackUrl($params['callbackUrl']);
      return \Iyzipay\Model\Subscription\SubscriptionCardUpdate::update($this->request,$this->options);
    }

    public function setSubscriptionCreateWithCustomerRequest(Array $params)
    {

      $this->request = new \Iyzipay\Request\Subscription\SubscriptionCreateWithCustomerRequest();
      $this->request->setLocale("tr");
      $this->request->setPricingPlanReferenceCode($params['pricingPlanReferenceCode']);
      $this->request->setSubscriptionInitialStatus($params['status']);
      $this->request->setCustomerReferenceCode($params['customerReferenceCode']);
      return \Iyzipay\Model\Subscription\SubscriptionCreateWithCustomer::create($this->request,$this->options);
    }

    public function setSubscriptionCustomer(Array $params){
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionCreateCustomerRequest();
      $this->request->setLocale($params['locale']);
      if(isset($params['conversationID']))
        $this->request->setConversationId($params['conversationID']);
      $customer = new \Iyzipay\Model\Customer();
      $customer->setName($params['name']);
      $customer->setSurname($params['surname']);
      $customer->setGsmNumber($params['number']);
      $customer->setEmail($params['email']);
      $customer->setIdentityNumber($params['tc']);
      $customer->setShippingContactName($params['contactName']);
      $customer->setShippingCity($params['city']);
      $customer->setShippingDistrict($params['district']);
      $customer->setShippingCountry($params['country']);
      $customer->setShippingAddress($params['address']);
      $customer->setBillingContactName($params['contactName']);
      $customer->setBillingCity($params['city']);
      $customer->setBillingDistrict($params['district']);
      $customer->setBillingCountry($params['country']);
      $customer->setBillingAddress($params['address']);
      $this->request->setCustomer($customer);
      return \Iyzipay\Model\Subscription\SubscriptionCustomer::create($this->request,$this->options);
    }

    public function getCustomer($referenceCode)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionRetrieveCustomerRequest();
      $this->request->setCustomerReferenceCode($referenceCode);
      return \Iyzipay\Model\Subscription\SubscriptionCustomer::retrieve($this->request,$this->options);
    }

    public function listSubscriptionCustomers()
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionListCustomersRequest();
      $this->request->setPage(1);
      $this->request->setCount(100);
      return \Iyzipay\Model\Subscription\RetrieveList::customers($this->request,$this->options);
    }

    public function cancelSubscription($referenceCode)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionCancelRequest();
      $this->request->setLocale("tr");
      $this->request->setSubscriptionReferenceCode($referenceCode);
      return \Iyzipay\Model\Subscription\SubscriptionCancel::cancel($this->request,$this->options);
    }

    public function upgradeSubscription(Array $params)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionUpgradeRequest();
      $this->request->setLocale("TR");
      $this->request->setSubscriptionReferenceCode($params['subscriptionReferenceCode']);
      $this->request->setNewPricingPlanReferenceCode($params['newPricingPlanReferenceCode']);
      $this->request->setUpgradePeriod("NOW");
      $this->request->setUseTrial(true);
      $this->request->setResetRecurrenceCount(true);
      return \Iyzipay\Model\Subscription\SubscriptionUpgrade::update($this->request,$this->options);
    }

    public function listProducts()
    {
        $this->request = new \Iyzipay\Request\Subscription\SubscriptionListProductsRequest();
        $this->request->setPage(1);
        $this->request->setCount(10);
        return \Iyzipay\Model\Subscription\RetrieveList::products($this->request,$this->options);

    }

    public function activeSubscription($referenceCode)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionActivateRequest();
      $this->request->setLocale("tr");
      $this->request->setSubscriptionReferenceCode($referenceCode);
      return \Iyzipay\Model\Subscription\SubscriptionActivate::update($this->request,$this->options);
    }

    public function retrieveSubscription($referenceCode)
    {
    $this->request = new \Iyzipay\Request\Subscription\SubscriptionDetailsRequest();
    $this->request->setSubscriptionReferenceCode($referenceCode);
    return \Iyzipay\Model\Subscription\SubscriptionDetails::retrieve($this->request,$this->options);
    }

    public function retrievePricingPlan($referenceCode)
    {
      $this->request = new \Iyzipay\Request\Subscription\SubscriptionRetrievePricingPlanRequest();
      $this->request->setPricingPlanReferenceCode($referenceCode);
      return \Iyzipay\Model\Subscription\SubscriptionPricingPlan::retrieve($this->request,$this->options);
    }

    public function callbackForm($token)
    {
      $this->request = new \Iyzipay\Request\Subscription\RetrieveSubscriptionCreateCheckoutFormRequest();
      $this->request->setCheckoutFormToken($_REQUEST['token']);
      return \Iyzipay\Model\Subscription\RetrieveSubscriptionCheckoutForm::retrieve($this->request,$this->options);
    }
}

<?php

namespace Fatchip\CTPayment\CTOrder;
use Fatchip\CTPayment\CTAddress\CTAddress;

/**
 * Class CTOrder
 * @package Fatchip\CTOrder
 */
class CTOrder
{
    protected $amount;
    protected $currency;
    protected $orderDesc;
    protected $payId;
    protected $email;

    /**
     * @var CTAddress
     */
    protected $billingAddress;
    /**
     * @var CTAddress
     */
    protected $shippingAddress;

    public function __construct()
    {
    }


    /**
     * @param mixed $Amount
     */
    public function setAmount($Amount)
    {
        $this->amount = $Amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $Currency
     */
    public function setCurrency($Currency)
    {
        $this->currency = $Currency;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $PayId
     */
    public function setPayId($PayId)
    {
        $this->payId = $PayId;
    }

    /**
     * @return mixed
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * @param mixed $orderDescription
     */
    public function setOrderDesc($orderDescription)
    {
        $this->orderDesc = $orderDescription;
    }

    /**
     * @return mixed
     */
    public function getOrderDesc()
    {
        return $this->orderDesc;
    }

    /**
     * @param \Fatchip\CTPayment\CTAddress\CTAddress $billingAddress
     */
    public function setBillingAddress($billingAddress) {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return \Fatchip\CTPayment\CTAddress\CTAddress
     */
    public function getBillingAddress() {
        return $this->billingAddress;
    }

    /**
     * @param \Fatchip\CTPayment\CTAddress\CTAddress $shippingAddress
     */
    public function setShippingAddress($shippingAddress) {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return \Fatchip\CTPayment\CTAddress\CTAddress
     */
    public function getShippingAddress() {
        return $this->shippingAddress;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }



}

<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 14.02.18
 * Time: 15:35
 */

namespace Fatchip\CTPayment\CTResponse;


class CTResponseInquire extends CTResponseIframe {

    protected $AmountAuth;

    protected $AmountCap;

    protected $AmountCred;

    /**
     * @param mixed $AmountAuth
     */
    public function setAmountAuth($AmountAuth) {
        $this->AmountAuth = $AmountAuth;
    }

    /**
     * @return mixed
     */
    public function getAmountAuth() {
        return $this->AmountAuth;
    }

    /**
     * @param mixed $AmountCap
     */
    public function setAmountCap($AmountCap) {
        $this->AmountCap = $AmountCap;
    }

    /**
     * @return mixed
     */
    public function getAmountCap() {
        return $this->AmountCap;
    }

    /**
     * @param mixed $AmountCred
     */
    public function setAmountCred($AmountCred) {
        $this->AmountCred = $AmountCred;
    }

    /**
     * @return mixed
     */
    public function getAmountCred() {
        return $this->AmountCred;
    }


} 

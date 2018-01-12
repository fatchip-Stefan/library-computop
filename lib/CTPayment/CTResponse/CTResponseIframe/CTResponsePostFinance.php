<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 12:02
 */


namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

/**
 * Class CTResponsePostFinance
 * @package Fatchip\CTPayment\CTResponseIframe\CTResponseIframe
 */
class CTResponsePostFinance extends CTResponseIframe
{
    /**
     * Zahlungszweck
     *
     * @var string
     */
    protected $PaymentPurpose;

    /**
     * Transaktionsnummer bei PostFinance
     *
     * @var string
     */
    protected $TID;

    /**
     * Dieser Parameter wird nur zurückgegeben, falls der Status=OK ist.
     *
     * NONE = keine Zahlungsgarantie
     * VALIDATED = Kundenkonto valide, aber keine Zahlungsgarantie
     * FULL = Zahlungsgarantie Hinweis:
     *
     * @var string
     */
    protected $PaymentGuarantee;

    /**
     * @var
     */
    protected $AccOwner;

    /**
     * Name des Kontoinhabers
     *
     * @var string
     */
    protected $AccNr;

    /**
     * @var string
     */
    protected $AccIBAN;

    /**
     * @var string
     */
    protected $AccBank;

    /**
     * @var string
     */
    protected $IBAN;

    /**
     * @var string
     */
    protected $BIC;

    /**
     * @var string
     */
    protected $TransactionID;

    /**
     * @param string $accBank
     */
    public function setAccBank($accBank)
    {
        $this->AccBank = $accBank;
    }

    /**
     * @return string
     */
    public function getAccBank()
    {
        return $this->AccBank;
    }

    /**
     * @param string $accIban
     */
    public function setAccIBAN($accIban)
    {
        $this->AccIBAN = $accIban;
    }

    /**
     * @return string
     */
    public function getAccIBAN()
    {
        return $this->AccIBAN;
    }

    /**
     * @param string $accNr
     */
    public function setAccNr($accNr)
    {
        $this->AccNr = $accNr;
    }

    /**
     * @return string
     */
    public function getAccNr()
    {
        return $this->AccNr;
    }

    /**
     * @param mixed $accOwner
     */
    public function setAccOwner($accOwner)
    {
        $this->AccOwner = $accOwner;
    }

    /**
     * @return mixed
     */
    public function getAccOwner()
    {
        return $this->AccOwner;
    }

    /**
     * @param string $bic
     */
    public function setBIC($bic)
    {
        $this->BIC = $bic;
    }

    /**
     * @return string
     */
    public function getBIC()
    {
        return $this->BIC;
    }

    /**
     * @param string $iban
     */
    public function setIBAN($iban)
    {
        $this->IBAN = $iban;
    }

    /**
     * @return string
     */
    public function getIBAN()
    {
        return $this->IBAN;
    }

    /**
     * @param string $paymentGuarantee
     */
    public function setPaymentGuarantee($paymentGuarantee)
    {
        $this->PaymentGuarantee = $paymentGuarantee;
    }

    /**
     * @return string
     */
    public function getPaymentGuarantee()
    {
        return $this->PaymentGuarantee;
    }

    /**
     * @param string $paymentPurpose
     */
    public function setPaymentPurpose($paymentPurpose)
    {
        $this->PaymentPurpose = $paymentPurpose;
    }

    /**
     * @return string
     */
    public function getPaymentPurpose()
    {
        return $this->PaymentPurpose;
    }

    /**
     * @param string $tid
     */
    public function setTID($tid)
    {
        $this->TID = $tid;
    }

    /**
     * @return string
     */
    public function getTID()
    {
        return $this->TID;
    }

    /**
     * @param string $transactionID
     */
    public function setTransactionID($transactionID)
    {
        $this->TransactionID = $transactionID;
    }

    /**
     * @return string
     */
    public function getTransactionID()
    {
        return $this->TransactionID;
    }
}

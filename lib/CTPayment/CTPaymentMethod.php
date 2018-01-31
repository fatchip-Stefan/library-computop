<?php

namespace Fatchip\CTPayment;

abstract class CTPaymentMethod extends Blowfish
{


    /**
     * Vom Paygate vergebene ID für die Zahlung. Z.B. zur Referenzierung in Batch-Dateien.
     *
     * @var string
     */
    protected $payID;


    /**
     * Array of mandatory field names. Has to be set in constructor
     * @var array
     */
    protected $mandatoryFields;

    /**
     * Calculate the MAC value.
     *
     * @param string $payId
     * @param string $transID
     * @param string $merchantID
     * @param integer $amount
     * @param string $currency
     * @param string $mac
     * @return string
     */
    abstract protected function ctHMAC($merchantID, $amount, $currency, $mac, $payId = "", $transID = "");


    /**
     * @param string $PayID
     */
    public function setPayID($PayID)
    {
        $this->payID = $PayID;
    }

    /**
     * @return string
     */
    public function getPayID()
    {
        return $this->payID;
    }


    /**
     * @param array $mandatoryFields
     */
    public function setMandatoryFields($mandatoryFields)
    {
        $this->mandatoryFields = $mandatoryFields;
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return $this->mandatoryFields;
    }
}

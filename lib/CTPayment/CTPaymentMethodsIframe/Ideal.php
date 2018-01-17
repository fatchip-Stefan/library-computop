<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class Ideal extends CTPaymentMethodIframe
{


  /**
   *  Ideal kann entweder direkt aufgerufen werden, oder über Sofort. Hierzu soll es setting geben in Backend
   *
   * @var bool
   */
    private $idealDirekt = true;

    /**
     * Nicht bei PPRO: BIC der ausgewählten Bank (siehe Abfrage der hinterlegten iDEAL-Banken)
     *
     *
     * @var string
     */
    protected $issuerID;

    /**
     * @param $amount
     * @param $currency
     * @param $urlSuccess
     * @param $urlFailure
     * @param $urlNotify
     * @param $orderDesc
     * @param $userData
     */
    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);

        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);

        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency', 'orderDesc', 'mac',
          'urlSuccess', 'urlFailure', 'urlNotify', ));
    }

    /**
     * @param boolean $idealDirekt
     */
    public function setIdealDirekt($idealDirekt)
    {
        $this->idealDirekt = $idealDirekt;
    }

    /**
     * @return boolean
     */
    public function getIdealDirekt()
    {
        return $this->idealDirekt;
    }



    /**
     * @param string $issuerID
     */
    public function setIssuerID($issuerID)
    {
        $this->issuerID = $issuerID;
    }

    /**
     * @return string
     */
    public function getIssuerID()
    {
        return $this->issuerID;
    }

    public function getCTPaymentURL()
    {
        if ($this->idealDirekt) {
            return 'https://www.computop-paygate.com/ideal.aspx';
        } else {
            return 'https://www.computop-paygate.com/sofort.aspx';
        }
    }

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getIssuerListURL()
    {
        $queryarray = array();
        $queryarray[] = 'merchantID=' . $this->getMerchantID();

        $query = join("&", $queryarray);

        $Len = strlen($query);  // Length of the plain text string
        $data = $this->ctEncrypt($query, $Len, $this->getBlowfishPassword());

        return 'https://www.computop-paygate.com/idealIssuerList.aspx' .  '?merchantID=' . $this->getMerchantID() . '&Len=' . $Len . "&Data=" . $data;
        ;
    }

    public function getSettingsDefinitions()
    {
        return 'Idealdirekt oder Sofort';
    }
}

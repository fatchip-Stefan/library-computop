<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class Mobilepay extends CTPaymentMethodIframe
{
    const paymentClass = 'Mobilepay';

    /**
     * Der param MobielNr kann, sofern bekannt aus dem Kundenkonto vorbelegt werden.
     * Diese option sollte aber im Backend auf aktiv bzw inaktiv gestellt werden können.
     * @var bool
     */
    protected $sendMobileNumber = false;

    /**
     * Sprache, in der das Mobilepay-Formular angezeigt werden soll.
     * Mögliche Werte: da, no, fi
     *
     * @var string
     */
    protected $language;

    /**
     * //Telefonnummer des Mobilepay-Accounts im Format +4595000012.
     * Der Parameter <mobileNr> kann, sofern bekannt aus dem Kundenkonto vorbelegt wreden.
     * Diese Option sollte aber im Backend auf aktiv bzw. inaktiv gestellt werden können.
     *
     * @var string
     */
    protected $MobileNr;

    /**
     * @param $config
     * @param $order
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
    }

    /**
     * @param string $mobileNr
     */
    public function setMobileNr($mobileNr)
    {
        $this->MobileNr = $mobileNr;
    }

    /**
     * @return string
     */
    public function getMobileNr()
    {
        return $this->MobileNr;
    }

    /**
     * @param boolean $sendMobileNumber
     */
    public function setSendMobileNumber($sendMobileNumber)
    {
        $this->sendMobileNumber = $sendMobileNumber;
    }

    /**
     * @return boolean
     */
    public function getSendMobileNumber()
    {
        return $this->sendMobileNumber;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    protected function getTransactionArray()
    {
        //first get obligitory from parent
        $queryarray =  parent::getTransactionArray();
        //Optional for mobilepay
        if (strlen($this->getLanguage()) > 0) {
            $queryarray[] = "Language=" . $this->getLanguage();
        }
        if ($this->getSendMobileNumber() && strlen($this->getMobileNr()) > 0) {
            $queryarray[] = "mobileNr=" . $this->getMobileNr();
        }
        return $queryarray;
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/MobilePayDB.aspx';
    }

    public function getSettingsDefinitions()
    {
        return 'SendMobileNr';
    }
}

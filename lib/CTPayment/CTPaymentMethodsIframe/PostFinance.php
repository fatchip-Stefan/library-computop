<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class PostFinance extends CTPaymentMethodIframe
{
    /**
     * Name des Kontoinhabers
     *
     * @var string
     */
    protected $AccOwner;

    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify
    ) {
        parent::__construct($config, $order);
        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);
        $this->setAccOwner($order->getBillingAddress()->getFirstName . ' ' . $order->getBillingAddress()->getLastName());
        $this->setMandatoryFields(array('MerchantID', 'TransID', 'Amount', 'Currency', 'MAC', 'OrderDesc',
          'urlSuccess', 'urlFailure', 'urlNotify', 'AccOwner' ));
    }

    /**
     * @param string $AccOwner
     */
    public function setAccOwner($AccOwner)
    {
        $this->AccOwner = $AccOwner;
    }

    /**
     * @return string
     */
    public function getAccOwner()
    {
        return $this->AccOwner;
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/postfinance.aspx';
    }

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getSettingsDefinitions()
    {
        return null;
    }
}

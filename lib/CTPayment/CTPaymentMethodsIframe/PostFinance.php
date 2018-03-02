<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class PostFinance extends CTPaymentMethodIframe
{
    const paymentClass = 'PostFinance';

    /**
     * Name des Kontoinhabers
     *
     * @var string
     */
    protected $accOwner;

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
        $this->setAccOwner($order->getBillingAddress()->getFirstName . ' ' . $order->getBillingAddress()->getLastName());
    }

    /**
     * @param string $accOwner
     */
    public function setAccOwner($accOwner)
    {
        $this->accOwner = $accOwner;
    }

    /**
     * @return string
     */
    public function getAccOwner()
    {
        return $this->accOwner;
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/postfinance.aspx';
    }

    public function getCTCaptureURL()
    {
        return null;
    }

    public function getSettingsDefinitions()
    {
        return null;
    }
}

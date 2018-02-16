<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class Przelewy24 extends CTPaymentMethodIframe
{
    /**
     * Name des Kontoinhabers
     *
     * @var string
     */
    protected $accOwner;

    /**
     * E-Mail-Adresse des Kontoinhabers
     *
     * @var string
     */
    protected $Email;

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
        $this->setEmail($order->getEmail());
        $this->setAccOwner($order->getBillingAddress()->getFirstName . ' ' . $order->getBillingAddress()->getLastName());
        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency', 'mac', 'orderDesc',
          'urlSuccess', 'urlFailure', 'urlNotify', 'accOwner', 'Email', ));
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->Email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
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
        return 'https://www.computop-paygate.com/p24.aspx';
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

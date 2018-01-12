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
    protected $AccOwner;

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
        $email
    ) {
        parent::__construct($config, $order);
        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);

        $this->setAccOwner($order->getBillingAddress()->getFirstName . ' ' . $order->getBillingAddress()->getLastName());
        $this->setEmail($email);
        $this->setMandatoryFields(array('MerchantID', 'TransID', 'Amount', 'Currency', 'MAC', 'OrderDesc',
          'urlSuccess', 'urlFailure', 'urlNotify', 'AccOwner', 'Email', ));
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
        return 'https://www.computop-paygate.com/p24.aspx';
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

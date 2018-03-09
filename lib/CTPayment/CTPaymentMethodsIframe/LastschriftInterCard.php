<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class LastschriftInterCard extends Lastschrift
{
    const paymentClass = 'LastschriftInterCard';

    /**
     * Bestimmt Art und Zeitpunkt der Buchung (engl. Capture).
     * AUTO: Buchung so-fort nach Autorisierung (Standardwert).
     * MANUAL: Buchung erfolgt durch den Händler.
     * <Zahl>: Verzögerung in Stunden bis zur Buchung (ganze Zahl; 1 bis 696).
     *
     * @var string
     */
    protected $capture; //AUTO, MANUAL, ZAHL

    /**
     * Kundennummer beim Händler
     *
     * @var string
     */
    protected $customerID;

    /**
     * Vorname der Rechnungsanschrift
     *
     * @var string
     */
    protected $bdFirstName;

    /**
     *  Nachname der Rechnungsanschrift
     *
     * @var string
     */
    protected $bdLastName;

    /**
     * Straßenname der Rechnungsanschrift
     *
     * @var string
     */
    protected $bdStreet;

    /**
     * Hausnummer der Rechnungsanschrift
     *
     * @var string
     */
    protected $bdStreetNr;

    /**
     * Postleitzahl der Rechnungsanschrift
     *
     * @var int
     */
    protected $bdZip;

    /**
     * Ortsname der Rechnungsanschrift
     *
     * @var string
     */
    protected $bdCity;

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
        $userData,
        $capture,
        $orderDesc2
    ) {
        parent::__construct($config, $order, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData, $capture);
        $this->setCustomerID($order->getCustomerID());
        $this->setBillingAddress($order->getBillingAddress());
    }

    public function setBillingAddress($billingAddress)
    {
        //for companies, first name must be empty
        $this->setBdLastName($billingAddress->getLastName());
        $this->setBdStreet($billingAddress->getStreet());
        $this->setBdStreetNr($billingAddress->getStreetNr());
        $this->setBdZip($billingAddress->getZip());
        $this->setBdCity($billingAddress->getCity());
    }

    /**
     * @return string
     */
    public function getCustomerID()
    {
        return $this->customerID;
    }

    /**
     * @param string $customerID
     */
    public function setCustomerID($customerID)
    {
        $this->customerID = $customerID;
    }

    /**
     * @return string
     */
    public function getBdFirstName()
    {
        return $this->bdFirstName;
    }

    /**
     * @param string $bdFirstName
     */
    public function setBdFirstName($bdFirstName)
    {
        $this->bdFirstName = $bdFirstName;
    }

    /**
     * @return string
     */
    public function getBdLastName()
    {
        return $this->bdLastName;
    }

    /**
     * @param string $bdLastName
     */
    public function setBdLastName($bdLastName)
    {
        $this->bdLastName = $bdLastName;
    }

    /**
     * @return string
     */
    public function getBdStreet()
    {
        return $this->bdStreet;
    }

    /**
     * @param string $bdStreet
     */
    public function setBdStreet($bdStreet)
    {
        $this->bdStreet = $bdStreet;
    }

    /**
     * @return string
     */
    public function getBdStreetNr()
    {
        return $this->bdStreetNr;
    }

    /**
     * @param string $bdStreetNr
     */
    public function setBdStreetNr($bdStreetNr)
    {
        $this->bdStreetNr = $bdStreetNr;
    }

    /**
     * @return int
     */
    public function getBdZip()
    {
        return $this->bdZip;
    }

    /**
     * @param int $bdZip
     */
    public function setBdZip($bdZip)
    {
        $this->bdZip = $bdZip;
    }

    /**
     * @return string
     */
    public function getBdCity()
    {
        return $this->bdCity;
    }

    /**
     * @param string $bdCity
     */
    public function setBdCity($bdCity)
    {
        $this->bdCity = $bdCity;
    }


}

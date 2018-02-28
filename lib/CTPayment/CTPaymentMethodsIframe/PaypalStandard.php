<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTAddress\CTAddress;
use Fatchip\CTPayment\CTPaymentMethodIframe;

class PaypalStandard extends CTPaymentMethodIframe
{
    /**
     * Auto oder Manual: bestimmt, ob der angefragte Betrag sofort oder erst später abgebucht wird.
     * Wichtiger Hinweis: Bitte kontaktieren Sie den Computop Support für Manual,
     * um die unterschiedlichen Einsatzmöglichkeiten abzuklären.
     *
     * @var string
     */
    protected $capture;

    /**
     * Pflicht bei Capture=Manual:
     * Transaktionstyp mit den möglichen Werten Order oder Auth sowie BAID (BillingAgreementID)
     *
     * @var string
     */
    protected $TxType;

    /**
     * optional, plficht für USA und Canada:
     * Entweder nur der Vorname oder Vor- und Nach-name, falls ein Firmenname als Lieferadresse genutzt wird.
     *
     * @var string
     */
    protected $FirstName;

    /**
     * optional, plficht für USA und Canada: Nachname oder Firmenbezeichnung der Lieferad-resse
     *
     * @var string
     */
    protected $LastName;

    /**
     * optional, plficht für USA und Canada: Straßenname der Lieferadresse
     * @var string
     */
    protected $AddrStreet;

    /**
     * optional: Straßenname der Lieferadresse
     *
     * @var string
     */
    protected $AddrStreet2;

    /**
     * optional, plficht für USA und Canada:
     * Ortsname der Lieferadresse
     *
     * @var string
     */
    protected $AddrCity;

    /**
     * optional, plficht für USA und Canada:
     * Bundesland (Bundesstaat) der Lieferadresse. Die in addrCity übergebene Stadt muss im angegebenen Bundesstaat
     * liegen, sonst lehnt PayPal die Zahlung ab.
     * Mögliche Werte entnehmen Sie bitte der PayPal-API-Reference Dokumentation.
     *
     * @var string
     */
    protected $AddrState;

    /**
     * optional, plficht für USA und Canada:
     * Postleitzahl der Lieferadresse
     *
     * @var string
     */
    protected $AddrZip;

    /**
     * optional, plficht für USA und Canada:
     * Ländercode des Lieferlandes (2stellig)
     *
     * @var string
     */
    protected $AddrCountryCode;

    protected $PayPalMethod = '';

    protected $NoShipping = 1;

    /**
     * @param $config
     * @param CTOrder $order
     * @param $urlSuccess
     * @param $urlFailure
     * @param $urlNotify
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

        //TODO: Check if this should always be order
        $this->setTxType('Order');

        $this->setCapture($config['paypalCaption']);

        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency', 'orderDesc', 'mac',
          'urlSuccess', 'urlFailure', ));
    }

    /**
     * @param string $capture
     */
    public function setCapture($capture)
    {
        $this->capture = $capture;
    }

    /**
     * @return string
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @param string $txType
     */
    public function setTxType($txType)
    {
        $this->TxType = $txType;
    }

    /**
     * @return string
     */
    public function getTxType()
    {
        return $this->TxType;
    }

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity)
    {
        $this->AddrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity()
    {
        return $this->AddrCity;
    }

    /**
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode)
    {
        $this->AddrCountryCode = $addrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode()
    {
        return $this->AddrCountryCode;
    }

    /**
     * @param string $addrState
     */
    public function setAddrState($addrState)
    {
        $this->AddrState = $addrState;
    }

    /**
     * @return string
     */
    public function getAddrState()
    {
        return $this->AddrState;
    }

    /**
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet)
    {
        $this->AddrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet()
    {
        return $this->AddrStreet;
    }

    /**
     * @param string $addrStreet2
     */
    public function setAddrStreet2($addrStreet2)
    {
        $this->AddrStreet2 = $addrStreet2;
    }

    /**
     * @return string
     */
    public function getAddrStreet2()
    {
        return $this->AddrStreet2;
    }

    /**
     * @param string $addrZip
     */
    public function setAddrZip($addrZip)
    {
        $this->AddrZip = $addrZip;
    }

    /**
     * @return string
     */
    public function getAddrZip()
    {
        return $this->AddrZip;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->FirstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;
    }

    /**
     * @return string
     */
    public function getPayPalMethod()
    {
        return $this->PayPalMethod;
    }

    /**
     * @param string $lastName
     */
    public function setPayPalMethod($payPalMethod)
    {
        $this->PayPalMethod = $payPalMethod;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param int $NoShipping
     */
    public function setNoShipping($NoShipping) {
        $this->NoShipping = $NoShipping;
    }

    /**
     * @return int
     */
    public function getNoShipping() {
        return $this->NoShipping;
    }

    /**
     * @param $shippingAddress CTAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->setFirstName($shippingAddress->getFirstName());
        $this->setLastName($shippingAddress->getLastName());
        if (strlen($shippingAddress->getStreetNr() > 0)) {
            $this->setAddrStreet($shippingAddress->getStreet() . ' ' . $shippingAddress->getStreetNr());
        } else {
            $this->setAddrStreet($shippingAddress->getStreet());
        }

        $this->setAddrZip($shippingAddress->getZip());
        $this->setAddrCity($shippingAddress->getCity());
        $this->setAddrCountryCode($shippingAddress->getCountryCode());
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/paypal.aspx';
    }

    public function getCaptureURL()
    {
        return 'https://www.computop-paygate.com/capture.aspx';
    }

    public function getReverseURL()
    {
        return 'https://www.computop-paygate.com/reverse.aspx';
    }

    public function getSettingsDefinitions()
    {
        return 'Capture (2 ausprägungen)';
    }
}

<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTEnums\CTEnumCapture;
use Fatchip\CTPayment\CTOrder\CTOrder;
use Fatchip\CTPayment\CTPaymentMethodIframe;

class CreditCard extends CTPaymentMethodIframe
{
    /**
     * Bestimmt Art und Zeitpunkt der Buchung (engl. Capture).
     * AUTO: Buchung so-fort nach Autorisierung (Standardwert).
     * MANUAL: Buchung erfolgt durch den Händler.
     * <Zahl>: Verzögerung in Stunden bis zur Buchung (ganze Zahl; 1 bis 696).
     *
     * @var string
     */
    protected $capture = 'AUTO';

    /**
     * Name der XSLT-Datei mit Ihrem individuellen Layout für das Bezahlformular.
     * Wenn Sie das neugestaltete und abwärtskompatible Computop-Template nut-zen möchten,
     * übergeben Sie den Templatenamen „ct_compatible“. Wenn Sie das Responsive Computop-Template für mobile Endgeräte
     * nutzen möchten, übergeben Sie den Templatenamen „ct_responsive“.
     * @var string
     */
    protected $Template;

    /**
     * @var
     */
    protected $acquirer;

    /**
     * Ein von Händler zu setzender Wert, um Informationen wieder unverschlüsselt zurückzugeben, zB die MID
     *
     * @var string
     */
    protected $plain;

    /*FIELD FOR AVS*/

    /**
     * Straßenname (für AVS)
     *
     * für GICC und Omnipay ohne hausnummer, für CAPN mit hausnummer
     *
     * @var string
     */
    protected $AddrStreet;

    /**
     * Hausnummer zur Verifizierung durch American Express (für AVS)
     *
     * @var string
     */
    protected $AddrStreetNr;

    /**
     * Postleitzahl (für AVS)
     *
     * @var string
     */
    protected $AddrZip;

    /**
     * Ortsname (für AVS)
     *
     * @var string
     */
    protected $AddrCity;

    /**
     * Code des Bundeslandes des Kunden
     *
     * @var string
     */
    protected $AddrState;

    /**
     * Ländercode im Format ISO-3166-1:
     * er kann wahlweise 2-stellig oder 3-istellig übergeben werden – Format a2 / a3 (für AVS)
     *
     * @var string
     */
    protected  $addrCountryCode;

    /* FIELDS FOR AMEX/CAPN*/
    /**
     * Prepaid-Karte: Tatsächlich autorisierter Betrag in der kleinsten Währungsein-heit.
     *
     * @var int
     */
    protected $AmountAuth;

    /**
     * Vorname des Kunden (für AVS)
     *
     * @var string
     */
    protected $FirstName;

    /**
     * Nachname des Kunden (für AVS)
     *
     * @var string
     */
    protected $LastName;

    /**
     * Vorname in der Lieferadresse (für AVS)
     *
     * @var string
     */
    protected $sdFirstName;

    /**
     * Nachname in der Lieferadresse (für AVS)     *
     *
     * @var string
     */
    protected $sdLastName;

    /**
     * Straßenname und Hausnummer in der Lieferadresse, z.B. 4102~N~289~PL (für AVS)
     *
     * @var string
     */
    protected $sdStreet;

    /**
     * Postleitzahl in der Lieferadresse
     *
     * @var string
     */
    protected $sdZip;

    /**
     * Ländercode der Lieferadresse im Format ISO-3166-1, numerisch 3-stellig (für AVS)
     *
     * @var string
     */

    protected $sdCountryCode;





    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/payssl.aspx';
    }


    /**
     * @param $config - array, must contain at least 'mac', 'blowfishpass' and 'merchantID'
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


        switch ($config['creditCardAcquirer']) {
            case 'GICC':
            case 'Omnipay':
                $this->setAddrStreet($order->getBillingAddress()->getStreet());
                $this->setAddrStreetNr($order->getBillingAddress()->getStreetNr());
                $this->setAddrZip($order->getBillingAddress()->getZip());
                $this->setAddrCity($order->getBillingAddress()->getCity());
                $this->setAddrCountryCode($order->getBillingAddress()->getCountryCode());
                $this->setAddrState($order->getBillingAddress()->getState());
                break;
            case 'CAPN':
                $this->setAmountAuth($order->getAmount());
                $this->setFirstName($order->getBillingAddress()->getFirstName());
                $this->setLastName($order->getBillingAddress()->getLastName());
                $this->setAddrStreet($order->getBillingAddress()->getStreet() . ' ' . $order->getBillingAddress()->getStreetNr());
                $this->setAddrZip($order->getBillingAddress()->getZip());
                $this->setSdFirstName($order->getShippingAddress()->getFirstName());
                $this->setSdLastName($order->getShippingAddress()->getLastName());
                $this->setSdStreet($order->getShippingAddress()->getStreet() . ' ' . $order->getShippingAddress()->getStreetNr());
                $this->setSdZip($order->getShippingAddress()->getZip());
                $this->setSdCountryCode($order->getShippingAddress()->getCountryCodeIso3()); //for CAPN: Country in Iso3 format


                break;
        }

        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency',
        'mac', 'urlSuccess', 'urlFailure', 'urlNotify', ));

        if ($config['creditCardCaption'] == CTEnumCapture::DELAYED && is_numeric($config['creditCardDelay'])) {
            $this->setCapture($config['creditCardDelay']);
        } else {
            $this->setCapture($config['creditCardCaption']);
        }
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
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet) {
        $this->AddrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet() {
        return $this->AddrStreet;
    }

    /**
     * @param string $addrStreetNr
     */
    public function setAddrStreetNr($addrStreetNr) {
        $this->AddrStreetNr = $addrStreetNr;
    }

    /**
     * @return string
     */
    public function getAddrStreetNr() {
        return $this->AddrStreetNr;
    }

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity) {
        $this->AddrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity() {
        return $this->AddrCity;
    }

    /**
     * @param string $addrZip
     */
    public function setAddrZip($addrZip) {
        $this->AddrZip = $addrZip;
    }

    /**
     * @return string
     */
    public function getAddrZip() {
        return $this->AddrZip;
    }

    /**
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode) {
        $this->addrCountryCode = $addrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode() {
        return $this->addrCountryCode;
    }

    /**
     * @param string $addrState
     */
    public function setAddrState($addrState) {
        $this->AddrState = $addrState;
    }

    /**
     * @return string
     */
    public function getAddrState() {
        return $this->AddrState;
    }

    /**
     * @param int $amountAuth
     */
    public function setAmountAuth($amountAuth) {
        $this->AmountAuth = $amountAuth;
    }

    /**
     * @return int
     */
    public function getAmountAuth() {
        return $this->AmountAuth;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->FirstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->FirstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->LastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->LastName;
    }

    /**
     * @param string $sdZip
     */
    public function setSdZip($sdZip) {
        $this->sdZip = $sdZip;
    }

    /**
     * @return string
     */
    public function getSdZip() {
        return $this->sdZip;
    }

    /**
     * @param string $sdCountryCode
     */
    public function setSdCountryCode($sdCountryCode) {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @return string
     */
    public function getSdCountryCode() {
        return $this->sdCountryCode;
    }

    /**
     * @param string $sdFirstName
     */
    public function setSdFirstName($sdFirstName) {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @return string
     */
    public function getSdFirstName() {
        return $this->sdFirstName;
    }

    /**
     * @param string $sdLastName
     */
    public function setSdLastName($sdLastName) {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @return string
     */
    public function getSdLastName() {
        return $this->sdLastName;
    }

    /**
     * @param string $sdStreet
     */
    public function setSdStreet($sdStreet) {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @return string
     */
    public function getSdStreet() {
        return $this->sdStreet;
    }





    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getSettingsDefinitions()
    {
        return 'Capture, Templateauswahl, Acquirerauswahl';
    }
}

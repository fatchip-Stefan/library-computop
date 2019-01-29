<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The Computop Shopware Plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Computop Shopware Plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Computop Shopware Plugin. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.6, 7.0 , 7.1
 *
 * @category   Payment
 * @package    FatchipCTPayment
 * @subpackage CTPaymentMethodsIframe
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTEnums\CTEnumCapture;
use Fatchip\CTPayment\CTOrder\CTOrder;
use Fatchip\CTPayment\CTPaymentMethodIframe;
/**
 * Class CreditCard
 */
class CreditCard extends CTPaymentMethodIframe
{
    const paymentClass = 'CreditCard';

    /**
     * Bestimmt Art und Zeitpunkt der Buchung (engl. Capture).
     * AUTO: Buchung so-fort nach Autorisierung (Standardwert).
     * MANUAL: Buchung erfolgt durch den Händler.
     * <Zahl>: Verzögerung in Stunden bis zur Buchung (ganze Zahl; 1 bis 696).
     *
     * @var string
     */
    protected $capture = 'MANUAL';

    /**
     * Name der XSLT-Datei mit Ihrem individuellen Layout für das Bezahlformular.
     * Wenn Sie das neugestaltete und abwärtskompatible Computop-Template nut-zen möchten,
     * übergeben Sie den Templatenamen „ct_compatible“. Wenn Sie das Responsive Computop-Template für mobile Endgeräte
     * nutzen möchten, übergeben Sie den Templatenamen „ct_responsive“.
     * @var string
     */
    protected $Template;

    /**
     * Creditcard acquirer
     * @var string
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
    protected $addrCountryCode;

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
     * Ländercode der Lieferadresse im Format ISO-3166-1, numerisch 3-stellig (für AVS)
     *
     * @var string
     */

    protected $sdCountryCode;

    /**
     * Optional: URL für Schaltfläche „Abbrechen“
     * @var string
     */
    protected $URLBack;

    /**
     * For Paynow/Silentmode:
     * Kreditkartennummer: mindestens 12stellig ohne Leerzeichen
     * @var string
     *
     */
    protected $CCNr;

    /**
     * For Paynow/Silentmode:
     * Kartenprüfnummer: Die letzten 3 Ziffern auf dem Unterschriftsfeld der Kredit-karte     *
     * @var string
     */
    protected $CCCVC;

    /**
     * For Paynow/Silentmode:
     * Ablaufdatum der Kreditkarte im Format YYYYMM, z.B. 201807
     * @var string
     */
    protected $CCExpiry;

    /**
     * For Paynow/Silentmode:
     * Kreditkartenmarke. MasterCard, VISA oder AMEX
     * @var string
     */
    protected  $CCBrand;

    /**
     * Übergeben Sie „Order“, um eine Zahlung zu initialisieren und diese später über die Schnittstelle authorize.aspx zu autorisieren.
     * Bitte beachten Sie, dass in Ver-bindung mit dem genutzten 3D-Secure-Verfahren eine separate Einstellung notwendig ist.
     *
     * @var string
     *
     */
    protected  $TxType;


    /**
     * returns paymentURL
     * @return string
     */
    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/payssl.aspx';
    }

    /**
     * returns PayNowURL
     * @return string
     */
    public function getCTPayNowURL()
    {
        return 'https://www.computop-paygate.com/paynow.aspx';
    }

    /**
     * returns paymentURL
     * @return string
     */
    public function getCTRecurringURL()
    {
        return 'https://www.computop-paygate.com/direct.aspx';
    }


    /**
     * Creditcard constructor
     *
     * @param array $config
     * @param CTOrder|null $order
     * @param null|string $urlSuccess
     * @param null|string $urlFailure
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
    )
    {
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
                $this->setSdCountryCode($order->getShippingAddress()->getCountryCodeIso3());
                break;
        }

        //we will handle all captures manually
        $this->setCapture('MANUAL');

        if (isset($config['creditCardTemplate'])) {
            $this->setTemplate($config['creditCardTemplate']);
        }

    }

    /**
     * @ignore <description>
     * @param string $capture
     */
    public function setCapture($capture)
    {
        $this->capture = $capture;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @ignore <description>
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet)
    {
        $this->AddrStreet = $addrStreet;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrStreet()
    {
        return $this->AddrStreet;
    }

    /**
     * @ignore <description>
     * @param string $addrStreetNr
     */
    public function setAddrStreetNr($addrStreetNr)
    {
        $this->AddrStreetNr = $addrStreetNr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrStreetNr()
    {
        return $this->AddrStreetNr;
    }

    /**
     * @ignore <description>
     * @param string $addrCity
     */
    public function setAddrCity($addrCity)
    {
        $this->AddrCity = $addrCity;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrCity()
    {
        return $this->AddrCity;
    }

    /**
     * @ignore <description>
     * @param string $addrZip
     */
    public function setAddrZip($addrZip)
    {
        $this->AddrZip = $addrZip;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrZip()
    {
        return $this->AddrZip;
    }

    /**
     * @ignore <description>
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode)
    {
        $this->addrCountryCode = $addrCountryCode;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrCountryCode()
    {
        return $this->addrCountryCode;
    }

    /**
     * @ignore <description>
     * @param string $addrState
     */
    public function setAddrState($addrState)
    {
        $this->AddrState = $addrState;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getAddrState()
    {
        return $this->AddrState;
    }

    /**
     * @ignore <description>
     * @param int $amountAuth
     */
    public function setAmountAuth($amountAuth)
    {
        $this->AmountAuth = $amountAuth;
    }

    /**
     * @ignore <description>
     * @return int
     */
    public function getAmountAuth()
    {
        return $this->AmountAuth;
    }

    /**
     * @ignore <description>
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->FirstName = $firstName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @ignore <description>
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @ignore <description>
     * @param string $sdCountryCode
     */
    public function setSdCountryCode($sdCountryCode)
    {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdCountryCode()
    {
        return $this->sdCountryCode;
    }

    /**
     * @ignore <description>
     * @param string $sdFirstName
     */
    public function setSdFirstName($sdFirstName)
    {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdFirstName()
    {
        return $this->sdFirstName;
    }

    /**
     * @ignore <description>
     * @param string $sdLastName
     */
    public function setSdLastName($sdLastName)
    {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdLastName()
    {
        return $this->sdLastName;
    }

    /**
     * @ignore <description>
     * @param string $sdStreet
     */
    public function setSdStreet($sdStreet)
    {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdStreet()
    {
        return $this->sdStreet;
    }

    /**
     * @ignore <description>
     * @param string $CCBrand
     */
    public function setCCBrand($CCBrand) {
        $this->CCBrand = $CCBrand;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCCBrand() {
        return $this->CCBrand;
    }

    /**
     * @ignore <description>
     * @param string $CCCVC
     */
    public function setCCCVC($CCCVC) {
        $this->CCCVC = $CCCVC;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCCCVC() {
        return $this->CCCVC;
    }

    /**
     * @ignore <description>
     * @param string $CCExpiry
     */
    public function setCCExpiry($CCExpiry) {
        $this->CCExpiry = $CCExpiry;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCCExpiry() {
        return $this->CCExpiry;
    }

    /**
     * @ignore <description>
     * @param string $CCNr
     */
    public function setCCNr($CCNr) {
        $this->CCNr = $CCNr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCCNr() {
        return $this->CCNr;
    }

    /**
     * @ignore <description>
     * @param string $TxType
     */
    public function setTxType($TxType) {
        $this->TxType = $TxType;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getTxType() {
        return $this->TxType;
    }


    /**
     * @ignore <description>
     * @param string $urlBack
     */
    public function setURLBack($urlBack) {
        $this->URLBack = $urlBack;
    }

    /**
     * @ignore <description>
     * @param string $Template
     */
    public function setTemplate($Template) {
        $this->Template = $Template;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getTemplate() {
        return $this->Template;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getURLBack() {
        return $this->URLBack;
    }


    /**
     * returns encrypted url for preauthorizations for paynow silent mode
     *
     * @param $ctRequest
     * @return string
     */
    public function getPaynowURL($ctRequest)
    {
        return $this->prepareComputopRequest($ctRequest, $this->getCTPayNowURL());
    }

    /**
     * returns url for preauthorizations for paynow silent mode
     *
     * @return string
     */
    public function getAuthorizeURL()
    {
        return 'https://www.computop-paygate.com/authorize.aspx';
    }

    /**
     * returns encoded url for a request with encoded Data and LEN queryparameters
     * Overridden, because for CreditCard we need to put the template param in the undecrypted part of the querystring
     * @param $ctRequest
     * @return string
     */
    public function getHTTPGetURL($ctRequest)
    {
        $url =  parent::prepareComputopRequest($ctRequest, $this->getCTPaymentURL());
        if (strlen($this->getTemplate()) > 0) {
            $url .= '&Template=' . $this->getTemplate();
        }
        return $url;
    }

    /**
     * sets and returns request parameters for server-to-server authorization calls
     *
     * @param $payID
     * @param $transID
     * @param $amount
     * @param $currency
     * @param $capture
     * @return array
     */
    public function getAuthorizeParams($payID, $transID, $amount, $currency, $capture)
    {
        $params = [
            'merchantID' => $this->merchantID,
            'PayID' => $payID,
            'TransID' => $transID,
            'Amount' => $amount,
            'Currency' => $currency,
            'Capture' => $capture,
        ];

        return $params;
    }

}

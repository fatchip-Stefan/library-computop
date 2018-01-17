<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTAddress\CTAddress;
use Fatchip\CTPayment\CTEnums\CTEnumCapture;
use Fatchip\CTPayment\CTPaymentMethodIframe;
use Fatchip\CTPayment\CTOrder\CTOrder;

class Paydirekt extends CTPaymentMethodIframe
{
    /**
     * Bestimmt Art und Zeitpunkt der Buchung (engl. Capture).
     * AUTO: Buchung so-fort nach der Autorisierung (Standardwert).
     * MANUAL: Buchung erfolgt durch den Händler.
     * <Zahl>: Verzögerung in Stunden bis zur Buchung (ganze Zahl; 1 bis 696).
     *
     * @var string
     */
    protected $capture;

    /**
     * API-Key des Shops bei paydirekt
     *
     * @var string
     */
    protected $ShopApiKey;
    /**
     * Warenwert der Bestellung ohne Versandkosten in der kleinsten Währungsein-heit (z.B. EUR Cent)
     * Bitte wenden Sie sich an den Helpdesk, wenn Sie Beträge < 100 (kleinste Wäh-rungseinheit) buchen möchten.
     *
     * @var int
     */
    protected $ShoppingBasketAmount;

    /**
     * Vorname in der Lieferanschrift
     * Pflicht, wenn ShoppingBasketCategory <> „AU-THORITIES_PAYMENT“ und <> „ANONYMOUS_DONATION“
     *
     * @var string
     */
    protected $sdFirstName;

    /**
     * Nachname in der Lieferanschrift.
     * Pflicht, wenn ShoppingBasketCategory <> „AUTHORITIES_PAYMENT“ und <> „ANONYMOUS_DONATION“
     *
     * @var string
     */
    protected $sdLastName;

    /**
     * Optional. Straßenname in der Lieferanschrift
     *
     * @var string
     */
    protected $sdStreet;

    /**
     * Optional: Hausnummer in der Lieferanschrift
     * @var string
     */

    protected $sdStreetNr;

    /**
     * Postleitzahl in der Lieferanschrift
     * Pflicht, wenn ShoppingBasketCategory <> "DIGITAL" und <> "AUTHORI-TIES_PAYMENT" und <> "ANONYMOUS_DONATION"
     *
     * @var int
     */
    protected $sdZip;

    /**
     * Ort in der Lieferanschrift #
     * Pflicht, wenn ShoppingBasketCategory <> "DIGITAL" und <> "AUTHORI-TIES_PAYMENT" und <> "ANONYMOUS_DONATION"
     *
     * @var string
     */
    protected $sdCity;

    /**
     * Ländercode in der Lieferanschrift (2stellig)
     * Pflicht, wenn ShoppingBasketCategory <> "DIGITAL" und <> "AUTHORI-TIES_PAYMENT" und <> "ANONYMOUS_DONATION"
     *
     * @var string
     */
    protected $sdCountryCode;

    /**
     * E-Mail-Adresse des Empfängers
     * Pflicht, wenn ShoppingBasketCategory = „DIGITAL“
     *
     * @var string
     */
    protected $sdEmail;


    /**
     * @param $config
     * @param \Fatchip\CTPayment\CTOrder $order
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

        if (empty($config['payDirektShopApiKey'])) {
            throw new \RuntimeException('Paydirekt ShopApiKey is not set in Plugin Config');
        }

        $this->setShopApiKey($config['payDirektShopApiKey']);

        $this->setShippingAddress($order->getShippingAddress());

        if ($config['payDirektCaption'] == CTEnumCapture::DELAYED && is_numeric($config['payDirektCardDelay'])) {
            $this->setCapture($config['payDirektCardDelay']);
        } else {
            $this->setCapture($config['payDirektCaption']);
        }

        //For Paydirekt, the transID has a max length of 20
        $this->transID = substr($this->transID, 0, 20);
        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency', 'mac',
          'urlSuccess', 'urlFailure', 'ShopApiKey' ));
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
     * @param string $shopAPIKey
     */
    public function setShopApiKey($shopAPIKey)
    {
        $this->ShopApiKey = $shopAPIKey;
    }

    /**
     * @return string
     */
    public function getShopApiKey()
    {
        return $this->ShopApiKey;
    }

    /**
     * @param int $shoppingBasketAmount
     */
    public function setShoppingBasketAmount($shoppingBasketAmount)
    {
        $this->ShoppingBasketAmount = $shoppingBasketAmount;
    }

    /**
     * @return int
     */
    public function getShoppingBasketAmount()
    {
        return $this->ShoppingBasketAmount;
    }



    /**
     * @param int $sdZip
     */
    public function setZip($sdZip)
    {
        $this->sdZip = $sdZip;
    }

    /**
     * @return int
     */
    public function getZip()
    {
        return $this->sdZip;
    }

    /**
     * @param string $sdCity
     */
    public function setCity($sdCity)
    {
        $this->sdCity = $sdCity;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->sdCity;
    }

    /**
     * @param string $sdCountryCode
     */
    public function setCountryCode($sdCountryCode)
    {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->sdCountryCode;
    }

    /**
     * @param string $sdEmail
     */
    public function setEmail($sdEmail)
    {
        $this->sdEmail = $sdEmail;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->sdEmail;
    }

    /**
     * @param string $sdFirstName
     */
    public function setFirstName($sdFirstName)
    {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->sdFirstName;
    }

    /**
     * @param string $sdLastName
     */
    public function setLastName($sdLastName)
    {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->sdLastName;
    }

    /**
     * @param string $sdStreet
     */
    public function setStreet($sdStreet)
    {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->sdStreet;
    }

    /**
     * @param string $sdsdStreetNr
     */
    public function setStreetNr($sdsdStreetNr)
    {
        $this->sdStreetNr = $sdsdStreetNr;
    }

    /**
     * @return string
     */
    public function getStreetNr()
    {
        return $this->sdStreetNr;
    }

    /**
     * @param $shippingAddress CTAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->setFirstName($shippingAddress->getFirstName());
        $this->setLastName($shippingAddress->getLastName());
        $this->setStreet($shippingAddress->getStreet());
        $this->setStreetNr($shippingAddress->getStreetNr());
        $this->setZip($shippingAddress->getZip());
        $this->setCity($shippingAddress->getCity());
        $this->setCountryCode($shippingAddress->getCountryCode());
    }

    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/paydirekt.aspx';
    }

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
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
        return 'Capture (3 ausprägungen), ShopApiKey';
    }
}

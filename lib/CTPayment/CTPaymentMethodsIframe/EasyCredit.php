<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;
use Fatchip\CTPayment\CTAddress\CTAddress;
use Fatchip\CTPayment\CTResponse\CTResponse;

use Exception;

class EasyCredit extends CTPaymentMethodIframe
{
    /**
     * Definiert die bei easyCredit auszuführende Anfrage: <INT> zur Initialisierung eines Vorgangs
     *
     * @var
     */
    protected $eventToken;

    /**
     * Anrede HERR oder FRAU
     *
     * @var string
     */
    protected $Salutation;

    /**
     * Vorname
     *
     * @var string
     */
    protected $FirstName;

    /**
     * Nachname
     *
     * @var string
     */
    protected $LastName;

    /**
     * Geburtsdatum im Format YYYY-MM-DD
     *
     * @var string
     */
    protected $DateOfBirth;

    //Billingaddress
    /**
     * Straße
     *
     * @var string
     */
    protected $bdStreet;

    /**
     * Hausnummer
     *
     * @var string
     */
    protected $bdStreetNr;

    /**
     * Adresszusatz
     *
     * @var string
     */
    protected $bdAddressAddition;

    /**
     * Postleitzahl
     *
     * @var int
     */
    protected $bdZip;

    /**
     * Stadt
     *
     * @var string
     */
    protected $bdCity;


    /**
     * Ländercode in der Rechnungsadresse gemäß ISO 3166, zweistellig. Derzeit ist nur DE erlaubt.
     *
     * @var string
     */
    protected $bdCountryCode;

    //Shippingaddress
    /**
     * Packstation
     *
     * @var string
     */
    protected $PackingStation;

    /**
     * Straße
     *
     * @var string
     */
    protected $sdStreet;

    /**
     * Hausnummer
     *
     * @var string
     */
    protected $sdStreetNr;

    /**
     * Adresszusatz
     * @var string
     */
    protected $sdAddressAddition;

    /**
     * Stadt
     *
     * @var string
     */
    protected $sdCity;

    /**
     * Ländercode in der Lieferdresse gemäß ISO 3166, zweistellig. Derzeit ist nur DE erlaubt.
     *
     * @var string
     */
    protected $sdCountryCode;

    //Kontaktdaten
    /**
     * E-Mail-Adresse des Kunden
     *
     * @var string
     */
    protected $Email;

    /**
     * Mobiltelefonnummer des Kunden
     *
     * @var string
     */
    protected $MobileNr;

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
     * @param mixed $eventToken
     */
    public function setEventToken($eventToken)
    {
        $this->eventToken = $eventToken;
    }

    /**
     * @return mixed
     */
    public function getEventToken()
    {
        return $this->eventToken;
    }

    /**
     * Geburtsdatum im Format YYYY-MM-DD
     *
     * @param string $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->DateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->DateOfBirth;
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
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation($salutation)
    {
        $this->Salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
        return $this->Salutation;
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
     * @param string $packingStation
     */
    public function setPackingStation($packingStation)
    {
        $this->PackingStation = $packingStation;
    }

    /**
     * @return string
     */
    public function getPackingStation()
    {
        return $this->PackingStation;
    }

    /**
     * @param string $bdAddressAddition
     */
    public function setBdAddressAddition($bdAddressAddition)
    {
        $this->bdAddressAddition = $bdAddressAddition;
    }

    /**
     * @return string
     */
    public function getBdAddressAddition()
    {
        return $this->bdAddressAddition;
    }

    /**
     * @param string $bdCity
     */
    public function setBdCity($bdCity)
    {
        $this->bdCity = $bdCity;
    }

    /**
     * @return string
     */
    public function getBdCity()
    {
        return $this->bdCity;
    }

    /**
     * @param string $bdCountryCode
     */
    public function setBdCountryCode($bdCountryCode)
    {
        $this->bdCountryCode = $bdCountryCode;
    }

    /**
     * @return string
     */
    public function getBdCountryCode()
    {
        return $this->bdCountryCode;
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
    public function getBdStreet()
    {
        return $this->bdStreet;
    }

    /**
     * @param string $bdStreetNr
     */
    public function setBdStreetNr($bdStreetNr)
    {
        $this->bdStreetNr = $bdStreetNr;
    }

    /**
     * @return string
     */
    public function getBdStreetNr()
    {
        return $this->bdStreetNr;
    }

    /**
     * @param int $bdZip
     */
    public function setBdZip($bdZip)
    {
        $this->bdZip = $bdZip;
    }

    /**
     * @return int
     */
    public function getBdZip()
    {
        return $this->bdZip;
    }

    /**
     * @param string $sdAddressAddition
     */
    public function setSdAddressAddition($sdAddressAddition)
    {
        $this->sdAddressAddition = $sdAddressAddition;
    }

    /**
     * @return string
     */
    public function getSdAddressAddition()
    {
        return $this->sdAddressAddition;
    }

    /**
     * @param string $sdCity
     */
    public function setSdCity($sdCity)
    {
        $this->sdCity = $sdCity;
    }

    /**
     * @return string
     */
    public function getSdCity()
    {
        return $this->sdCity;
    }

    /**
     * @param string $sdCountryCode
     */
    public function setSdCountryCode($sdCountryCode)
    {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @return string
     */
    public function getSdCountryCode()
    {
        return $this->sdCountryCode;
    }

    /**
     * @param string $sdStreet
     */
    public function setSdStreet($sdStreet)
    {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @return string
     */
    public function getSdStreet()
    {
        return $this->sdStreet;
    }

    /**
     * @param string $sdStreetNr
     */
    public function setSdStreetNr($sdStreetNr)
    {
        $this->sdStreetNr = $sdStreetNr;
    }

    /**
     * @return string
     */
    public function getSdStreetNr()
    {
        return $this->sdStreetNr;
    }



    /***
     * @param $config
     * @param $order
     * @param $urlSuccess
     * @param $urlFailure
     * @param $urlNotify
     * @param $orderDesc
     * @param $userData
     * @param $eventToken
     */
    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData,
        $eventToken
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);

        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);

        $this->setShippingAddress($order->getShippingAddress());
        $this->setBillingAddress($order->getBillingAddress());

        if ($order->getBillingAddress()) {
            $this->setFirstName($order->getBillingAddress()->getFirstName());
            $this->setLastName($order->getBillingAddress()->getLastName());
            $this->setSalutation($order->getBillingAddress()->getSalutation());
        }

        $this->setEventToken($eventToken);
        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency',
          'eventToken', 'urlSuccess', 'urlFailure', 'urlNotify', ));
    }


    /**
     * @param $shippingAddress CTAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        if (isset($shippingAddress)) {
            $this->setSdStreet($shippingAddress->getStreet());
            $this->setSdStreetNr($shippingAddress->getStreetNr());
            $this->setSdZip($shippingAddress->getZip());
            $this->setSdCity($shippingAddress->getCity());
            $this->setSdCountryCode($shippingAddress->getCountryCode());
        }
    }

    /**
     * @param $billingAddress CTAddress
     */
    public function setBillingAddress($billingAddress)
    {
        if (isset($billingAddress)) {
            $this->setBdStreet($billingAddress->getStreet());
            $this->setBdStreetNr($billingAddress->getStreetNr());
            $this->setBdZip($billingAddress->getZip());
            $this->setBdCity($billingAddress->getCity());
            $this->setBdCountryCode($billingAddress->getCountryCode());
            $this->setSalutation($billingAddress->getSalutation());
        }
    }

    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/easyCredit.aspx';
    }

    public function getSettingsDefinitions()
    {
        return null;
    }

    /**
     * @param $payID
     * @return CTResponse
     */
    public function getDecision($payID)
    {
        return $this->callEasyCreditDirect($payID, 'GET');
    }

    public function confirm($payID)
    {
        return $this->callEasyCreditDirect($payID, 'CON');
    }

    /**
     * @param $payID
     * @param $EventToken
     * @return CTResponse
     */
    private function callEasyCreditDirect($payID, $EventToken)
    {
        $this->setPayID($payID);
        $this->setEventToken($EventToken);
        $query = $this->getTransactionQuery();
        $Len = strlen($query);
        $data = $this->getEncryptedData();
        $url = 'https://www.computop-paygate.com/easyCreditDirect.aspx' . '?merchantID=' . $this->getMerchantID() . '&Len=' . $Len . "&Data=" . $data;
        ;

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => $url,
        ));

        try {
        $resp = curl_exec($curl);

        if (FALSE === $resp) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }

        } catch (\Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
              E_USER_ERROR);
        }

        $arr = array();
        $respArray = $this->ctSplit(explode('&', $resp), '=');
        $plaintext = $this->ctDecrypt($respArray['Data'], $respArray['Len'], $this->getBlowfishPassword());

        parse_str($plaintext, $arr);
        $respObj = new CTResponse($arr);

        return $respObj;
    }

    private function ctSplit($arText, $sSplit)
    {
        $arr = [];
        foreach ($arText as $text) {
            $str = explode($sSplit, $text);
            $arr[$str[0]] = $str[1];
        }
        return $arr;
    }
}

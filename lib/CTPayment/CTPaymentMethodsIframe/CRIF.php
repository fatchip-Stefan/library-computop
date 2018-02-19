<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 15.01.18
 * Time: 11:00
 */

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;
use Fatchip\CTPayment\CTPaymentMethodIframe;
use Fatchip\CTPayment\CTOrder\CTOrder;


class CRIF extends CTPaymentMethodIframe{

    /**
     * Prüfmethode: <QuickCheckConsumer>, <CreditCheckConsumer>, <QuickCheckBusiness>,
     * <Cre-ditCheckBusiness>, <IdentCheckConsumer>
     *
     * @var string
     */
    protected $productName;

    /**
     * Kundennummer/Kundenreferenz
     *
     * @var string
     */
    protected $customerID;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected  $firstName;

    /**
     * @var string
     */
    protected $addrStreet;

    /**
     * @var string
     */
    protected $addrStreetNr;

    /**
     * @var string
     */
    protected $addrCity;


    /**
     * Ländercode dreistellig gemäß ISO 3166. Nur AUT, DEU, CHE, NLD zulässig.
     *
     * @var string
     */
    protected $AddrCountryCode;

    /**
     * @var string
     */
    protected $addrZip;

    /**
     * @var
     */
    protected $sdLastName;

    /**
     * @var
     */
    protected $sdFirstName;

    /**
     * @var
     */
    protected $sdGender;

    /**
     * @var
     */
    protected $sdStreet;

    /**
     * @var
     */
    protected $sdStreetNr;

    /**
     * @var
     */
    protected $sdCity;


    /**
     * Ländercode dreistellig gemäß ISO 3166. Nur AUT, DEU, CHE, NLD zulässig.
     *
     * @var string
     */
    protected $sdCountryCode;


    /**
     * @param $config
     * @param CTOrder $order
     * @param $orderDesc
     * @param $userData
     */
    public function __construct(
      $config,
      $order,
      $orderDesc,
      $userData
    )
    {
        parent::__construct($config, $order, $orderDesc, $userData);

        $this->setLastName($order->getBillingAddress()->getLastName());
        $this->setFirstName($order->getBillingAddress()->getFirstName());
        $this->setAddrStreet($order->getBillingAddress()->getStreet());
        $this->setAddrStreetNr($order->getBillingAddress()->getStreetNr());
        $this->setAddrZip($order->getBillingAddress()->getZip());
        $this->setAddrCity($order->getBillingAddress()->getCity());
        $this->setAddrCountryCode($order->getBillingAddress()->getCountryCodeIso3());

        $this->setSdFirstName($order->getShippingAddress()->getFirstName());
        $this->setSdFirstName($order->getShippingAddress()->getFirstName());
        $this->setSdStreet($order->getShippingAddress()->getStreet());
        $this->setSdStreetNr($order->getShippingAddress()->getStreetNr());
        //sdZip is set in parent constructor.
        $this->setSdCity($order->getShippingAddress()->getCity());
        $this->setSdCountryCode($order->getShippingAddress()->getCountryCodeIso3());


        $this->setMandatoryFields(array('merchantID', 'transID', 'orderDesc', 'amount', 'currency',
          'mac', 'productName', 'customerID', 'lastName', 'addrStreet', 'addrZip' ));

        $basicMethod = $config['crifmethod'];
        if ($basicMethod != 'inactive') {
            $isCompany = strlen($order->getBillingAddress()->getCompany()) > 0;
            if ($isCompany) {
                $this->setProductName($basicMethod . 'Business');
            } else {
                $this->setProductName($basicMethod . 'Consumer');
            }
        }

        $this->setOrderDesc($orderDesc);

        $this->setCustomerID($order->getCustomerID());

    }

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity)
    {
        $this->addrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity()
    {
        return $this->addrCity;
    }

    /**
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet)
    {
        $this->addrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet()
    {
        return $this->addrStreet;
    }

    /**
     * @param string $addrStreetNr
     */
    public function setAddrStreetNr($addrStreetNr)
    {
        $this->addrStreetNr = $addrStreetNr;
    }

    /**
     * @return string
     */
    public function getAddrStreetNr()
    {
        return $this->addrStreetNr;
    }

    /**
     * @param string $addrZip
     */
    public function setAddrZip($addrZip)
    {
        $this->addrZip = $addrZip;
    }

    /**
     * @return string
     */
    public function getAddrZip()
    {
        return $this->addrZip;
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
    public function getCustomerID()
    {
        return $this->customerID;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param mixed $sdCity
     */
    public function setSdCity($sdCity)
    {
        $this->sdCity = $sdCity;
    }

    /**
     * @return mixed
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
     * @param mixed $sdFirstName
     */
    public function setSdFirstName($sdFirstName)
    {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @return mixed
     */
    public function getSdFirstName()
    {
        return $this->sdFirstName;
    }

    /**
     * @param mixed $sdGender
     */
    public function setSdGender($sdGender)
    {
        $this->sdGender = $sdGender;
    }

    /**
     * @return mixed
     */
    public function getSdGender()
    {
        return $this->sdGender;
    }

    /**
     * @param mixed $sdLastName
     */
    public function setSdLastName($sdLastName)
    {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @return mixed
     */
    public function getSdLastName()
    {
        return $this->sdLastName;
    }

    /**
     * @param mixed $sdStreet
     */
    public function setSdStreet($sdStreet)
    {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @return mixed
     */
    public function getSdStreet()
    {
        return $this->sdStreet;
    }

    /**
     * @param mixed $sdStreetNr
     */
    public function setSdStreetNr($sdStreetNr)
    {
        $this->sdStreetNr = $sdStreetNr;
    }

    /**
     * @return mixed
     */
    public function getSdStreetNr()
    {
        return $this->sdStreetNr;
    }

    /**
     * @param string $AddrCountryCode
     */
    public function setAddrCountryCode($AddrCountryCode)
    {
        $this->AddrCountryCode = $AddrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode()
    {
        return $this->AddrCountryCode;
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/deltavista.aspx';
    }

    public function getCTRefundURL()
    {
        return null;
    }

    public function getSettingsDefinitions()
    {
        return null;
    }

    public function callCRFDirect()
    {

        $url = $this->getHTTPGetURL();
        $curl = curl_init();
        $resp = null;

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
        parse_str($resp, $arr);


        return $arr;
    }


}

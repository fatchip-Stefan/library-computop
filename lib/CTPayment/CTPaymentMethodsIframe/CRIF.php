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
use Fatchip\CTPayment\CTResponse\CTResponseIframe\CTResponseCRIF;

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
     * @var string
     */
    protected $addrZip;


    public function __construct(
      $config,
      $order

    ) {
        parent::__construct($config, $order);


        $this->setLastName($order->getBillingAddress()->getLastName());
        $this->setAddrStreet($order->getBillingAddress()->getStreet());
        $this->setAddrStreetNr($order->getBillingAddress()->getStreetNr());
        $this->setAddrZip($order->getBillingAddress()->getZip());
        $this->setAddrCity($order->getBillingAddress()->getCity());

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

        //TODO: orderdesc implementieren
        $this->setOrderDesc('testDesc');

        //TODO: CustomerID übergeben
        $this->setCustomerID('1212');

    }

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity) {
        $this->addrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity() {
        return $this->addrCity;
    }

    /**
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet) {
        $this->addrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet() {
        return $this->addrStreet;
    }

    /**
     * @param string $addrStreetNr
     */
    public function setAddrStreetNr($addrStreetNr) {
        $this->addrStreetNr = $addrStreetNr;
    }

    /**
     * @return string
     */
    public function getAddrStreetNr() {
        return $this->addrStreetNr;
    }

    /**
     * @param string $addrZip
     */
    public function setAddrZip($addrZip) {
        $this->addrZip = $addrZip;
    }

    /**
     * @return string
     */
    public function getAddrZip() {
        return $this->addrZip;
    }

    /**
     * @param string $customerID
     */
    public function setCustomerID($customerID) {
        $this->customerID = $customerID;
    }

    /**
     * @return string
     */
    public function getCustomerID() {
        return $this->customerID;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $productName
     */
    public function setProductName($productName) {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductName() {
        return $this->productName;
    }

    public function getCTPaymentURL() {
        return 'https://www.computop-paygate.com/deltavista.aspx';
    }

    public function getCTRefundURL() {
        return null;
    }

    public function getSettingsDefinitions() {
        return null;
    }

    public function callCRFDirect()
    {

        $url = $this->getHTTPGetURL();

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
        parse_str($resp, $arr);
        $decryptedRequest = $this->ctDecrypt($arr['Data'], $arr['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponseCRIF($requestArray);


        return $response;
    }


} 

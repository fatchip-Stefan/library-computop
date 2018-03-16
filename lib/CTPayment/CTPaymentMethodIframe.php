<?php

namespace Fatchip\CTPayment;

use Fatchip\CTPayment\CTOrder;
use Fatchip\CTPayment\CTResponse;


abstract class CTPaymentMethodIframe extends CTPaymentMethod
{
  /**
   * Betrag in der kleinsten Währungseinheit (z.B. EUR Cent).
   * Bitte wenden Sie sich an den Helpdesk, wenn Sie Beträge < 100 (kleinste Wäh-rungseinheit) buchen möchten.
   * @var int
   */
    protected $amount;

    /**
     * Währung, drei Zeichen DIN / ISO 4217
     *
     * @var
     */
    protected $currency = 'EUR';

    /**
     * Wenn beim Aufruf angegeben, übergibt das Paygate die Parameter mit dem Zahlungsergebnis an den Shop
     *
     * @var string
     */
    protected $userData;

    /**
     * Vollständige URL, die das Paygate aufruft, wenn die Zahlung erfolgreich war.
     * Die URL darf nur über Port 443 aufgerufen werden.
     * Diese URL darf keine Para-meter enthalten:
     * Um Parameter durchzureichen nutzen Sie stattdessen den Pa-rameter UserData.
     *
     * @var string
     */
    protected $urlSuccess;

    /**
     * Vollständige URL, die das Paygate aufruft, wenn die Zahlung gescheitert ist.
     * Die URL darf nur über Port 443 aufgerufen werden.
     * Diese URL darf keine Parame-ter enthalten:
     * Um Parameter durchzureichen nutzen Sie stattdessen den Para-meter UserData.
     *
     * @var string
     */
    protected $urlFailure;

    /**
     * Vollständige URL, die das Paygate aufruft, um den Shop zu benachrichtigen.
     * Die URL darf nur über Port 443 aufgerufen werden.
     * Sie darf keine Parameter enthalten: Nutzen Sie stattdessen den Parameter UserData.
     *
     * @var string
     */
    protected $urlNotify;

    /**
     * Beschreibung der gekauften Waren, Einzelpreise etc.
     *
     * @var string
     */
    protected $orderDesc;

    /**
     * TransaktionsID, die für jede Zahlung eindeutig sein muss
     * Bitte beachten Sie bei einigen Anbindungen die abweichenden Formate,
     * die bei den spezifischen Parametern angegeben sind.
     *
     * @var string
     */
    protected $transID;


    /**
     * @var CTOrder
     */
    protected $order;

    /**
     * Die Status-Rückmeldung, die das Paygate an urlSuccess und urlFailure sendet, sollte verschlüsselt werden.
     * Dazu übergeben Sie den Parameter Response=encrypt.
     *
     * @var string
     */
    protected $response = 'encrypt';

    /**
     * Eindeutige Referenznummer des Händlers
     *
     * @var string
     */
    protected $refNr;

    /**
     * Um Doppelzahlungen zu vermeiden, übergeben Sie einen alphanumerischen Wert,
     * der Ihre Transaktion identifiziert und nur einmal vergeben werden darf.
     * Falls die Transaktion mit derselben ReqID erneut eingereicht wird,
     * führt das Paygate keine Zahlung aus sondern gibt nur den Status der ursprünglichen Transaktion zurück
     *
     * @var string
     */
    protected $reqID;

    /**
     * IP-Adresse des Kunden im Format IPv4 oder IPv6
     *
     * @var string
     */
    protected $IPAddr;

    /**
     * Postleitzahl in der Lieferadresse.
     *
     * @var string
     */
    protected $sdZip;


   /***
    * @param array $config
    * @param CTOrder\CTOrder $order
    * @param string $orderDesc
    * @param string $userData
    */
    public function __construct($config, $order = null, $orderDesc = null, $userData = null)
    {
        $this->setAmount($order->getAmount());
        $this->setCurrency($order->getCurrency());
        $this->setOrderDesc($orderDesc);
        $this->setUserData($userData);
        $this->setIPAddr($_SERVER['REMOTE_ADDR']);
        // ToDO why set here sdzip????
        if ($order->getShippingAddress()) {
            $this->setSdZip($order->getShippingAddress()->getZip());
        }


        if (count($config) > 0) {
            $this->init($config);
        }

        mt_srand((double)microtime() * 1000000);
        $this->transID = (string)mt_rand();
        $this->transID .= date('yzGis');
        $this->setResponse('encrypt');

        mt_srand((double)microtime() * 1000000);
        $this->reqID = (string)mt_rand();
        $this->reqID .= date('yzGis');
    }

    protected function init(array $data = array())
    {
        foreach ($data as $key => $value) {
            $key = ucwords(str_replace('_', ' ', $key));
            $method = 'set' . str_replace(' ', '', str_replace('-', '', $key));
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            } else {
                $reflect = new \ReflectionClass($this);
                $currentClassName = $reflect->getShortName();
                $method = 'set' . str_replace($currentClassName, '', str_replace(' ', '', str_replace('-', '', $key)));
                if (method_exists($this, $method)) {
                    $this->{$method}($value);
                }
            }
        }
    }

    abstract public function getCTPaymentURL();

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getCTCaptureURL()
    {
        return 'https://www.computop-paygate.com/capture.aspx';
    }

    public function getCTInquireURL() {
        return 'https://www.computop-paygate.com/inquire.aspx';
    }

    /**
     * @param int $Amount
     */
    public function setAmount($Amount)
    {
        $this->amount = $Amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $Currency
     */
    public function setCurrency($Currency)
    {
        $this->currency = $Currency;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $UserData
     */
    public function setUserData($UserData)
    {
        $this->userData = $UserData;
    }

    /**
     * @return string
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }


    /**
     * @param string $TransID
     */
    public function setTransID($TransID)
    {
        $this->transID = $TransID;
    }

    /**
     * @return string
     */
    public function getTransID()
    {
        return $this->transID;
    }

    /**
     * @param string $urlSuccess
     */
    public function setUrlSuccess($urlSuccess)
    {
        $this->urlSuccess = $urlSuccess;
    }

    /**
     * @return string
     */
    public function getUrlSuccess()
    {
        return $this->urlSuccess;
    }

    /**
     * @param string $urlNotify
     */
    public function setUrlNotify($urlNotify)
    {
        $this->urlNotify = $urlNotify;
    }

    /**
     * @return string
     */
    public function getUrlNotify()
    {
        return $this->urlNotify;
    }

    /**
     * @param string $orderDesc
     */
    public function setOrderDesc($orderDesc)
    {
        $this->orderDesc = $orderDesc;
    }

    /**
     * @return string
     */
    public function getOrderDesc()
    {
        return $this->orderDesc;
    }



    /**
     * @param string $urlFailure
     */
    public function setUrlFailure($urlFailure)
    {
        $this->urlFailure = $urlFailure;
    }

    /**
     * @return string
     */
    public function getUrlFailure()
    {
        return $this->urlFailure;
    }


    /**
     * @param \Fatchip\CTPayment\CTOrder $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @param string $iPAddr
     */
    public function setIPAddr($iPAddr)
    {
        $this->IPAddr = $iPAddr;
    }

    /**
     * @return string
     */
    public function getIPAddr()
    {
        return $this->IPAddr;
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


    public function getRedirectUrlParams()
    {
        $requestParams = [];
        foreach ($this as $key => $value) {
            if (!is_null($value) && !array_key_exists($key, $this::paramexcludes)){
                $requestParams[$key] = $value;
            }
        }
        return $requestParams;
    }

    public function getHTTPGetURL($ctRequest)
    {
        return $this->prepareComputopRequest($ctRequest, $this->getCTPaymentURL());
    }
}

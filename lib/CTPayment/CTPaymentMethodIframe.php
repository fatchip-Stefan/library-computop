<?php

namespace Fatchip\CTPayment;

use Fatchip\CTPayment\CTOrder;


abstract class CTPaymentMethodIframe extends CTPaymentMethod
{

  /**
   * Betrag in der kleinsten Währungseinheit (z.B. EUR Cent).
   * Bitte wenden Sie sich an den Helpdesk, wenn Sie Beträge < 100 (kleinste Wäh-rungseinheit) buchen möchten.
   * @var int
   */
    private $amount;

    /**
     * Währung, drei Zeichen DIN / ISO 4217
     *
     * @var
     */
    private $currency = 'EUR';

    /**
     * Wenn beim Aufruf angegeben, übergibt das Paygate die Parameter mit dem Zahlungsergebnis an den Shop
     *
     * @var string
     */
    private $userData;

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



    /*Defintions*/
    /**
     * @var
     */
    protected $settingsDefinitions;

    /**
     * @var
     */
    protected $transactionDBFieldDefinitions;


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
     * @param $config
     * @param $order CTOrder
     */
    public function __construct($config, $order, $orderDesc, $userData)
    {
        $this->setAmount($order->getAmount());
        $this->setCurrency($order->getCurrency());
        $this->setOrderDesc($orderDesc);
        $this->setUserData($userData);




        if (count($config) > 0) {
            $this->init($config);
        }

        mt_srand((double)microtime() * 1000000);
        $this->transID = (string)mt_rand();
        $this->transID .= date('yzGis');
        $this->setResponse('encrypt');
        $this->setMandatoryFields(array('amount', 'currency'));
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

    abstract public function getCTRefundURL();

    abstract public function getSettingsDefinitions();


    public function getTransactionQuery()
    {
        $query = array();
        $query = $this->getTransactionArray();
        return join("&", $query);
    }


    protected function getTransactionArray()
    {
        $result = array();
        //check if all mandatory fields are set
        $arrMandatory = $this->getMandatoryFields();

        foreach ($arrMandatory as $manField) {
            if (!isset($this->$manField)) {
                throw new \RuntimeException("Madatory field " . $manField . ' is not set');
            }
        }

        foreach ($this as $key => $data) {
            if ($data === null || is_array($data)) {
                continue;
            } else {
                if ($key == 'mac') {
                    $result[] = $key . '=' . $this->getMACHash();
                } else {
                    $result[] = $key . '=' . $data;
                }
            }
        }

        return $result;
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
     * {@inheritDoc}
     * ToDo: get rid of params?
     */
    protected function ctHMAC($merchantID, $amount, $currency, $hmacPassword, $payId = '', $transID = '')
    {
        return hash_hmac(
            "sha256",
          "$payId*$this->transID*$this->merchantID*$this->amount*$this->currency",
            $this->getMac()
        );
    }

    protected function getMACHash()
    {
        return $this->ctHMAC(
          $this->getMerchantID(),
          $this->getAmount(),
          $this->getCurrency(),
          $this->getMac(),
          $this->getPayID(),
          $this->getTransID()
        );
    }

    public function getEncryptedData()
    {
        $plaintext = $this->getTransactionQuery();
        $Len = mb_strlen($plaintext);  // Length of the plain text string
        return $this->ctEncrypt($plaintext, $Len, $this->getBlowfishPassword());
    }

    public function getHTTPGetURL()
    {
        $query = $this->getTransactionQuery();
        $Len = mb_strlen($query);
        $data = $this->getEncryptedData();
        return $this->getCTPaymentURL() . '?merchantID=' . $this->getMerchantID() . '&Len=' . $Len . "&Data=" . $data;
    }

    public function getForm() {
        $URL = $this->getCTPaymentURL();
        $merchantID = $this->getMerchantID();
        $query = $this->getTransactionQuery();
        $Len = mb_strlen($query);
        $data = $this->getEncryptedData();

        $form = "<FORM method='POST' action='$URL'>
                <INPUT type='hidden' name='merchantID' value='$merchantID'>
                <INPUT type='hidden' name='Len' value='$Len'>
                <INPUT type='hidden' name='Data' value='$data'>
                <INPUT type='hidden' name='Background'
                value='https://www.meinshop.de/grafik/hintergrundbild.jpg'>
                <INPUT type='submit' name='Zahlen' value='Zahlen'>
                </FORM>";

        return $form;
    }



}

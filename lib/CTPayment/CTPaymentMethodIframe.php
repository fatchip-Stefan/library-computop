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

namespace Fatchip\CTPayment;

use Fatchip\CTPayment\CTOrder;
use Fatchip\CTPayment\CTResponse;

/**
 * Class CTPaymentMethodIframe
 * @package Fatchip\CTPayment
 */
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
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * Wenn beim Aufruf angegeben, übergibt das Paygate die Parameter mit dem Zahlungsergebnis an den Shop
     *
     * @var string
     */
    protected $userData;

    /**
     * ID die an CT übergeben wird damit CT reports über herkünft Transactionen machen kann
     * Wird mit gleichen wert gefüllt als userData
     * @var string
     */
    protected $EtiId;

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
     * CT Order object
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


   /**
    * CTPaymentMethodIFrame constructor
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
        $this->setEtiId($userData);
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

    /**
     * Initiates the PaymentMethod object from an array.
     * It checks if a setter method exists for the array key, and calls it if it exists.
     * If no setter is found, through reflection it cuts of the name of the paymentmethod from the setter
     * and tries again.
     *
     * @param array $data
     */
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

    /**
     * returns PaymentURL
     * @return mixed
     */
    abstract public function getCTPaymentURL();

    /**
     * returns the Refund/debit url
     * @return string
     */
    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    /**
     * returns CaptureURL
     * @return string
     */
    public function getCTCaptureURL()
    {
        return 'https://www.computop-paygate.com/capture.aspx';
    }

    /**
     * returns InquireURL, used to inquire at CT for payment status
     * @return string
     */
    public function getCTInquireURL() {
        return 'https://www.computop-paygate.com/inquire.aspx';
    }

    /**
     * @ignore <description>
     * @param int $Amount
     */
    public function setAmount($Amount)
    {
        $this->amount = $Amount;
    }

    /**
     * @ignore <description>
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @ignore <description>
     * @param mixed $Currency
     */
    public function setCurrency($Currency)
    {
        $this->currency = $Currency;
    }

    /**
     * @ignore <description>
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @ignore <description>
     * @param string $UserData
     */
    public function setUserData($UserData)
    {
        $this->userData = $UserData;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @ignore <description>
     * @param string $EtiId
     */
    public function setEtiId($EtiId) {
        $this->EtiId = $EtiId;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getEtiId() {
        return $this->EtiId;
    }


    /**
     * @ignore <description>
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }


    /**
     * @ignore <description>
     * @param string $TransID
     */
    public function setTransID($TransID)
    {
        $this->transID = $TransID;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getTransID()
    {
        return $this->transID;
    }

    /**
     * @ignore <description>
     * @param string $urlSuccess
     */
    public function setUrlSuccess($urlSuccess)
    {
        $this->urlSuccess = $urlSuccess;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getUrlSuccess()
    {
        return $this->urlSuccess;
    }

    /**
     * @ignore <description>
     * @param string $urlNotify
     */
    public function setUrlNotify($urlNotify)
    {
        $this->urlNotify = $urlNotify;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getUrlNotify()
    {
        return $this->urlNotify;
    }

    /**
     * @ignore <description>
     * @param string $orderDesc
     */
    public function setOrderDesc($orderDesc)
    {
        $this->orderDesc = $orderDesc;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getOrderDesc()
    {
        return $this->orderDesc;
    }

    /**
     * @ignore <description>
     * @param string $urlFailure
     */
    public function setUrlFailure($urlFailure)
    {
        $this->urlFailure = $urlFailure;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getUrlFailure()
    {
        return $this->urlFailure;
    }


    /**
     * @ignore <description>
     * @param \Fatchip\CTPayment\CTOrder $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @ignore <description>
     * @param string $iPAddr
     */
    public function setIPAddr($iPAddr)
    {
        $this->IPAddr = $iPAddr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getIPAddr()
    {
        return $this->IPAddr;
    }

    /**
     * @ignore <description>
     * @param string $sdZip
     */
    public function setSdZip($sdZip) {
        $this->sdZip = $sdZip;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdZip() {
        return $this->sdZip;
    }


    /**
     * returns parameters for redirectURL
     * @return array
     */
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

    /**
     * returns encoded url for a request with encoded Data and LEN queryparameters
     * @param $ctRequest
     * @return string
     */
    public function getHTTPGetURL($ctRequest)
    {
        return $this->prepareComputopRequest($ctRequest, $this->getCTPaymentURL());
    }
}

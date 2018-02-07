<?php
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
 * PHP version 5.6, 7 , 7.1
 *
 * @category  Payment
 * @package   Computop_Shopware5_Plugin
 * @author    FATCHIP GmbH <support@fatchip.de>
 * @copyright 2018 Computop
 * @license   <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link      https://www.computop.com
 */

namespace Fatchip\CTPayment;

use Fatchip\CTPayment\CTPaymentMethodsIframe\CRIF;
use Fatchip\CTPayment\CTPaymentMethodsIframe\Sofort;
use Fatchip\CTPayment\CTResponse\CTResponseIframe\CTResponseCreditCard;
use Fatchip\CTPayment\CTResponse\CTResponseIframe\CTResponseCRIF;
use Fatchip\CTPayment\CTResponse\CTResponseIframe\CTResponseEasyCredit;
use Fatchip\CTPayment\CTPaymentMethodsIframe\CreditCard;

class CTPaymentService extends Blowfish
{
    /**
     * @param $config
     */
    public function __construct($blowfishPassword)
    {
        $this->blowfishPassword = $blowfishPassword;
    }

    public function getPaymentClass($className, $config, $ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData)
    {
        //Ideal can be called directly, or via Sofort with SofortAction=ideal.
        //If set to 'via sofort' in Pluginsettings, return a class of type Sofort with Sofortaction = ideal
        if ($className == 'Ideal' && $config['idealDirektOderUeberSofort'] == 'SOFORT') {
            $obj = new Sofort($config,$ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData);
            $obj->setSofortAction('ideal');
            return $obj;
        }

        $class = 'Fatchip\\CTPayment\\CTPaymentMethodsIframe\\' . $className;
        return new $class($config,$ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData);
    }

    public function getCRIFClass($config, $order, $orderDesc, $userData ) {
        return new CRIF($config, $order, $orderDesc, $userData );
    }


    /**
     * decrypts raw responses from computop api
     *
     * ToDO check phpdocblocks and define the $rawRequest array
     *
     * @param $rawRequest array
     * @return CTResponseCreditCard
     */
    public function createPaymentResponse(array $rawRequest)
    {
        // Instead if using getter / setter use constructor to simplify
        $decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponseCreditCard($requestArray);
        return $response;
    }

    public function createCRIFResponse(array $rawRequest)
    {
        // Instead if using getter / setter use constructor to simplify
        $decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponseCRIF($requestArray);
        return $response;
    }

    /**
     * decrypts raw responses from computop api
     *
     * ToDO check phpdocblocks and define the $rawRequest array
     *
     * @param $rawRequest array
     * @return CTResponseEasyCredit
     */
    public function createECPaymentResponse(array $rawRequest)
    {
        // Instead if using getter / setter use constructor to simplify
        //$decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        //$requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponseEasyCredit($rawRequest);
        return $response;
    }

    /**
     * Create HTML with parameters in a NVP array
     * ToDO Fix Docblock
     * Split the elements in the passed array $arText by the split-string $sSplit
     *
     * @param string[] $arText
     * @param string $sSplit
     * @return array
     */
    private function ctSplit($arText, $sSplit)
    {
        $arr = [];
        foreach ($arText as $text) {
            $str = explode($sSplit, $text);
            $arr[$str[0]] = $str[1];
        }
        return $arr;
    }


    /**
     * @param CTResponseCreditCard $response
     * @param string $token
     * @return bool
     */
    public function isValidToken(CTResponseCreditCard $response, $token)
    {
        return hash_equals($token, $response->getUserData());
    }

    /**
     * @param float $amount
     * @param int $customerId
     * @return string
     */
    public function createPaymentToken($amount, $customerId)
    {
        return md5(implode('|', [$amount, $customerId]));
    }

    public function getPaymentMethods()
    {
        return array(
            array(
                'name' => 'fatchip_computop_creditcard',
                'shortname' => 'Kreditkarte',
                'description' => 'Computop Kreditkarte',
                'action' => 'FatchipCTCreditCard',
            ),
            array(
                'name' => 'fatchip_computop_easycredit',
                'shortname' => 'Easycredit',
                'description' => 'Computop Easycredit',
                'action' => 'FatchipCTEasyCredit',
                'template' => 'fatchip_computop_payment_easycredit.tpl',
                'additionalDescription' => 'Rechnungs- und Lieferadresse müssen gleich sein, damit easyCredit genutzt werden kann',
            ),
            array(
                'name' => 'fatchip_computop_ideal',
                'shortname' => 'iDEAL',
                'description' => 'Computop iDEAL',
                'action' => 'FatchipCTIdeal',
                'template' => 'fatchip_computop_payment_ideal.tpl',
                'countries' => array('NL'),
            ),
            array(
                'name' => 'fatchip_computop_klarna',
                'shortname' => 'Klarna',
                'description' => 'Computop Klarna',
                'action' => 'FatchipCTKlarna',
                'template' => 'fatchip_computop_payment_klarna.tpl',
            ),
            array(
                'name' => 'fatchip_computop_lastschrift',
                'shortname' => 'Lastschrift',
                'description' => 'Computop Lastschrift',
                'action' => 'FatchipCTLastschrift',
            ),
            array(
                'name' => 'fatchip_computop_mobilepay',
                'shortname' => 'Mobile Pay',
                'description' => 'Computop Mobile Pay',
                'action' => 'FatchipCTMobilepay',
                'countries' => array('DK', 'NO', 'FI', 'SE')
            ),
            array(
                'name' => 'fatchip_computop_paydirekt',
                'shortname' => 'Paydirekt',
                'description' => 'Computop Paydirekt',
                'action' => 'FatchipCTPaydirekt',
            ),
            array(
                'name' => 'fatchip_computop_paypal_standard',
                'shortname' => 'PayPal',
                'description' => 'Computop PayPal Standard',
                'action' => 'FatchipCTPaypalStandard',
            ),
            array(
                'name' => 'fatchip_computop_postfinance',
                'shortname' => 'Postfinance',
                'description' => 'Computop Postfinance',
                'action' => 'FatchipCTPostFinance',
            ),
            array(
                'name' => 'fatchip_computop_przelewy24',
                'shortname' => 'Przelewy24',
                'description' => 'Przelewy24',
                'action' => 'FatchipCTPrzelewy24',
                'countries' => array('PL',)
            ),
            array(
                'name' => 'fatchip_computop_sofort',
                'shortname' => 'SOFORT',
                'description' => 'Computop SOFORT',
                'action' => 'FatchipCTSofort',
                'template' => 'fatchip_computop_payment_sofort.tpl',
            ),
            array(
                'name' => 'fatchip_computop_amazonpay',
                'shortname' => 'AmazonPay',
                'description' => 'Computop AmazonPay',
                'action' => 'FatchipCTAmazon',
            ),
        );
    }
}

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
use Fatchip\CTPayment\CTResponse\CTResponse;


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

        //Lastschrift is an abstract class and cannot be instantiated directly
        if ($className == 'Lastschrift') {
            if ($config['lastschriftDienst'] == 'EVO') {
                $className = 'LastschriftEVO';
            }
            else if ($config['lastschriftDienst'] == 'DIREKT') {
                $className = 'LastschriftDirekt';
            }
            else if ($config['lastschriftDienst'] == 'INTERCARD') {
                $className = 'LastschriftInterCard';
            }
        }

        $class = 'Fatchip\\CTPayment\\CTPaymentMethodsIframe\\' . $className;
        return new $class($config,$ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData);
    }

    public function getCRIFClass($config, $order, $orderDesc, $userData ) {
        return new CRIF($config, $order, $orderDesc, $userData );
    }

    public function getPaymentConfigForms() {
        return new CTPaymentConfigForms();
    }


    /**
     * decrypts raw responses from computop api
     *
     * ToDO check phpdocblocks and define the $rawRequest array
     *
     * @param $rawRequest array
     * @return CTResponse
     */
    public function createPaymentResponse(array $rawRequest)
    {
        // Instead if using getter / setter use constructor to simplify
        $decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponse($requestArray);
        return $response;
    }


    /**
     * decrypts raw responses from computop api
     *
     * ToDO check phpdocblocks and define the $rawRequest array
     *
     * @param $rawRequest array
     * @return CTResponse
     */
    public function createECPaymentResponse(array $rawRequest)
    {
        // Instead if using getter / setter use constructor to simplify
        $decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponse($requestArray);
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
     * @param CTResponse $response
     * @param string $token
     * @return bool
     */
    public function isValidToken(CTResponse $response, $token)
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

    /** Note: setting 'countries' => ['NL'], in shopware
     * will make the payment available only for shippingCountry = nl
     * not billingCountry as expected
     * @return array
     */
    public function getPaymentMethods()
    {
        return [
            [
                'name' => 'fatchip_computop_creditcard',
                'shortname' => 'Kreditkarte',
                'description' => 'Computop Kreditkarte',
                'action' => 'FatchipCTCreditCard',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'CreditCard',
            ],
            [
                'name' => 'fatchip_computop_easycredit',
                'shortname' => 'Easycredit',
                'description' => 'Computop Easycredit',
                'action' => 'FatchipCTEasyCredit',
                'template' => 'fatchip_computop_easycredit.tpl',
                'additionalDescription' => 'Rechnungs- und Lieferadresse müssen gleich sein, damit easyCredit genutzt werden kann',
                'className' => 'EasyCredit',
            ],
            [
                'name' => 'fatchip_computop_ideal',
                'shortname' => 'iDEAL',
                'description' => 'Computop iDEAL',
                'action' => 'FatchipCTIdeal',
                'template' => 'fatchip_computop_ideal.tpl',
                'additionalDescription' => '',
                'className' => 'Ideal',
                'countries' => ['NL'],
            ],
            [
                'name' => 'fatchip_computop_klarna_invoice',
                'shortname' => 'Klarna Rechnungskauf',
                'description' => 'Computop Klarna Rechnungskauf',
                'action' => 'FatchipCTKlarna',
                'template' => 'fatchip_computop_klarna_invoice.tpl',
                'additionalDescription' => '',
                'className' => 'Klarna',
                'countries' => ['DE', 'NL', 'DK', 'FI', 'SE', 'NO'],
            ],
            [
                'name' => 'fatchip_computop_klarna_installment',
                'shortname' => 'Klarna Ratenkauf',
                'description' => 'Computop Klarna Ratenkauf',
                'action' => 'FatchipCTKlarna',
                'template' => 'fatchip_computop_klarna_installment.tpl',
                'additionalDescription' => '',
                'className' => 'Klarna',
                'countries' => ['NL'],
            ],
            [
                'name' => 'fatchip_computop_lastschrift',
                'shortname' => 'Lastschrift',
                'description' => 'Computop Lastschrift',
                'action' => 'FatchipCTLastschrift',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Lastschrift',
            ],
            [
                'name' => 'fatchip_computop_mobilepay',
                'shortname' => 'Mobile Pay',
                'description' => 'Computop Mobile Pay',
                'action' => 'FatchipCTMobilepay',
                'countries' => ['DK', 'NO', 'FI', 'SE'],
                'template' => '',
                'additionalDescription' => '',
                'className' => 'MobilePay',
            ],
            [
                'name' => 'fatchip_computop_paydirekt',
                'shortname' => 'Paydirekt',
                'description' => 'Computop Paydirekt',
                'action' => 'FatchipCTPaydirekt',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Paydirekt',
            ],
            [
                'name' => 'fatchip_computop_paypal_standard',
                'shortname' => 'PayPal',
                'description' => 'Computop PayPal Standard',
                'action' => 'FatchipCTPaypalStandard',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'PaypalStandard',
            ],
            [
                'name' => 'fatchip_computop_paypal_express',
                'shortname' => 'PayPalExpress',
                'description' => 'Computop PayPal Express',
                'action' => 'FatchipCTPaypalExpress',
                'template' => '',
                'additionalDescription' => '',
                'className' => '',
            ],
            [
                'name' => 'fatchip_computop_postfinance',
                'shortname' => 'Postfinance',
                'description' => 'Computop Postfinance',
                'action' => 'FatchipCTPostFinance',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'PostFinance',
            ],
            [
                'name' => 'fatchip_computop_przelewy24',
                'shortname' => 'Przelewy24',
                'description' => 'Computop Przelewy24',
                'action' => 'FatchipCTPrzelewy24',
                'countries' => ['PL',],
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Przelewy24',
            ],
            [
                'name' => 'fatchip_computop_sofort',
                'shortname' => 'SOFORT',
                'description' => 'Computop SOFORT',
                'action' => 'FatchipCTSofort',
                'template' => 'fatchip_computop_sofort.tpl',
                'additionalDescription' => '',
                'className' => 'Sofort',
            ],
            [
                'name' => 'fatchip_computop_amazonpay',
                'shortname' => 'AmazonPay',
                'description' => 'Computop AmazonPay',
                'action' => 'FatchipCTAmazon',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'CTAmazon',
            ],
        ];
    }}

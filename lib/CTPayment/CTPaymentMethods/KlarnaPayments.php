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
 * @subpackage CTPaymentMethods
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */

namespace Fatchip\CTPayment\CTPaymentMethods;

use Exception;
use Fatchip\CTPayment\CTPaymentMethod;
use Fatchip\CTPayment\CTResponse;
use Shopware\Plugins\FatchipCTPayment\Util;
use Shopware_Plugins_Frontend_FatchipCTPayment_Bootstrap as FatchipCTPayment;

/**
 * @package Fatchip\CTPayment\CTPaymentMethods
 */
class KlarnaPayments extends CTPaymentMethod
{
    const paymentClass = 'KlarnaPayments';

    /** @var array */
    protected $klarnaSessionRequestParams;
    /** @var array */
    protected $klarnaOrderRequestParams;
    /** @var array */
    protected $klarnaRefNrChangeRequestParams;
    /** @var array */
    protected $klarnaChangeBillingShippingRequestParams;
    /** @var array */
    protected $klarnaUpdateArtikelListRequestParams;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->merchantID = $config['merchantID'];
        $this->blowfishPassword = $config['blowfishPassword'];
        $this->mac = $config['mac'];
    }

    /**
     * @return array
     */
    public function getKlarnaUpdateArtikelListRequestParams(): array
    {
        return $this->klarnaUpdateArtikelListRequestParams;
    }

    /**
     * Stores update article list request parameters for Klarna
     *
     * @param $payId
     * @param $transId
     * @param $amount
     * @param $currency
     * @param $eventToken
     * @param $articleList
     */

    public function storeKlarnaUpdateArtikelListRequestParams(
        $payId,
        $transId,
        $amount,
        $currency,
        $eventToken,
        $articleList
    )
    {
        $this->klarnaUpdateArtikelListRequestParams = [
            'payID' => $payId,
            'transID' => $transId,
            'amount' => $amount,
            'currency' => $currency,
            'EventToken' => $eventToken,
            'ArticleList' => $articleList,
        ];
    }

    /**
     * Returns RefNrChangeURL, used to set the refNr for a transaction in CT-Analytics
     *
     * @return string
     */
    public function getCTRefNrChangeURL()
    {
        return 'https://www.computop-paygate.com/KlarnaPayments.aspx';
    }

    /**
     * Stores refNrChange request parameters for Klarna
     *
     * @param $payId
     * @param $eventToken
     * @param $refNr
     */
    public function storeKlarnaRefNrChangeRequestParams(
        $payId,
        $eventToken,
        $refNr
    )
    {
        $this->klarnaRefNrChangeRequestParams = [
            'payID' => $payId,
            'EventToken' => $eventToken,
            'RefNr' => $refNr,
        ];
    }

    /**
     * Sets and returns request parameters for reference number change api call
     *
     * @param $payId
     * @param $refNr
     * @return array
     * @deprecated
     *
     */
    public function getRefNrChangeParams($payId, $refNr)
    {
        // TODO: refactor this to two separate calls
        // storeKlarnaRefNrChangeRequestParams($payId, $eventToken, $refNr) and
        // getRefNrChangeParams() without any parameters
        $eventToken = 'UMR';

        $this->storeKlarnaRefNrChangeRequestParams($payId, $eventToken, $refNr);

        return $this->klarnaRefNrChangeRequestParams;
    }

    /**
     * @return array
     */
    public function getKlarnaRefNrChangeRequestParams()
    {
        return $this->klarnaRefNrChangeRequestParams;
    }

    /**
     * @return array
     */
    public function getKlarnaChangeBillingShippingRequestParams()
    {
        return $this->klarnaChangeBillingShippingRequestParams;
    }

    /**
     * $billingData = [
     *     'bdTitle' => '',
     *     'bdFirstName' => '',
     *     'bdLastName' => '',
     *     'bdCompany' => '',
     *     'bdStreet' => '',
     *     'bdAddrAddition' => '',
     *     'bdZip' => '',
     *     'bdCity' => '',
     *     'bdRegion' => '',
     *     'bdCountryCode' => '',
     *     'bdEmail' => '',
     *     'bdPhone' => '',
     * ];
     *
     * The $shippingData array is the same, but the key prefix is 'sd'.
     *
     * @param $payId
     * @param $eventToken
     * @param array $billingData
     * @param array $shippingData
     */
    public function storeKlarnaChangeBillingShippingRequestParams($payId, $eventToken, $billingData, $shippingData)
    {
        $this->klarnaChangeBillingShippingRequestParams = [
            'payID' => $payId,
            'EventToken' => $eventToken,
        ];

        // Only set meaningful values
        foreach ($billingData as $key => $value) {
            if ($value) {
                $this->klarnaChangeBillingShippingRequestParams['bd' . $key] = $value;
            }
        }

        foreach ($shippingData as $key => $value) {
            if ($value) {
                $this->klarnaChangeBillingShippingRequestParams['sd' . $key] = $value;
            }
        }
    }

    /**
     * Returns PaymentURL
     *
     * @return string
     */
    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/KlarnaPayments.aspx';
    }

    /**
     * Stores session request parameters for Klarna
     *
     * @param $taxAmount
     * @param $articleList
     * @param $urlConfirm
     * @param $payType
     * @param $account
     * @param $bdCountryCode
     * @param $amount
     * @param $currency
     * @param $transId
     * @param $ipAddress
     */
    public function storeKlarnaSessionRequestParams(
        $taxAmount,
        $articleList,
        $urlConfirm,
        $payType,
        $account,
        $bdCountryCode,
        $amount,
        $currency,
        $transId,
        $ipAddress
    )
    {
        $this->klarnaSessionRequestParams = [
            'TaxAmount' => $taxAmount,
            'ArticleList' => $articleList,
            'URLConfirm' => $urlConfirm,
            'PayType' => $payType,
            'Account' => $account,
            'bdCountryCode' => $bdCountryCode,
            'amount' => $amount,
            'currency' => $currency,
            'transID' => $transId,
            'IPAddr' => $ipAddress,
        ];
    }

    /**
     * Stores order request parameters for Klarna
     *
     * @param $payId
     * @param $transId
     * @param $amount
     * @param $currency
     * @param $tokenExt
     * @param $eventToken
     */
    public function storeKlarnaOrderRequestParams(
        $payId,
        $transId,
        $amount,
        $currency,
        $tokenExt,
        $eventToken
    )
    {
        $this->klarnaOrderRequestParams = [
            'payID' => $payId,
            'transID' => $transId,
            'amount' => $amount,
            'currency' => $currency,
            'TokenExt' => $tokenExt,
            'EventToken' => $eventToken
        ];
    }

    /**
     * @return array
     */
    public function getKlarnaSessionRequestParams()
    {
        return $this->klarnaSessionRequestParams;
    }

    /**
     * @param int $digitCount Optional parameter for the length of resulting
     *                        transID. The default value is 12.
     *
     * @return string The transID with a length of $digitCount.
     */
    public static function generateTransID($digitCount = 12)
    {
        mt_srand((double)microtime() * 1000000);

        $transID = (string)mt_rand();
        // y: 2 digits for year
        // m: 2 digits for month
        // d: 2 digits for day of month
        // H: 2 digits for hour
        // i: 2 digits for minute
        // s: 2 digits for second
        $transID .= date('ymdHis');
        // $transID = md5($transID);
        $transID = substr($transID, 0, $digitCount);

        return $transID;
    }

    /**
     * Creates the Klarna article list. The list is json and then base64 encoded.
     *
     * @return string
     */
    public static function createArticleListBase64()
    {
        /** @var Util $utils */
        $utils = Shopware()->Container()->get('FatchipCTPaymentUtils');

        $articleList = [];

        try {
            foreach (Shopware()->Modules()->Basket()->sGetBasket()['content'] as $item) {
                $quantity = (int)$item['quantity'];
                $itemTaxAmount = round(str_replace(',', '.', $item['tax']) * 100);
                $totalAmount = round(str_replace(',', '.', $item['price']) * 100) * $quantity;
                $articleList['order_lines'][] = [
                    'name' => $item['articlename'],
                    'quantity' => $quantity,
                    'unit_price' => round($item['priceNumeric'] * 100),
                    'total_amount' => $totalAmount,
                    'tax_rate' => $item['tax_rate'] * 100,
                    'total_tax_amount' => $itemTaxAmount,
                ];
            }
        } catch (Exception $e) {
            return '';
        }

        $shippingCosts = $utils->calculateShippingCosts();

        if ($shippingCosts) {
            $articleList['order_lines'][] = [
                'name' => 'shippingcosts',
                'quantity' => 1,
                'unit_price' => $shippingCosts * 100,
                'total_amount' => $shippingCosts * 100,
                'tax_rate' => 0,
                'total_tax_amount' => 0,
            ];
        }

        /** @var string $articleList */
        $articleList = base64_encode(json_encode($articleList));

        return $articleList;
    }

    /**
     * Creates an md5 hash from current billing and shipping addresses.
     *
     * @return string
     */
    public static function createAddressHash()
    {
        $userData = Shopware()->Modules()->Admin()->sGetUserData();

        /** @var string $address */
        $address = md5(serialize($userData['billingaddress']) . serialize($userData['shippingaddress']));

        return $address;
    }

    /**
     * Calculates the Klarna tax amount by adding the tax amounts of each position in the article list.
     *
     * @param $articleList
     *
     * @return float
     */
    public static function calculateTaxAmount($articleList)
    {
        $taxAmount = 0;
        $articleList = json_decode(base64_decode($articleList), true);
        foreach ($articleList['order_lines'] as $article) {
            $itemTaxAmount = $article['total_tax_amount'];
            $taxAmount += $itemTaxAmount;
        }

        return $taxAmount;
    }

    /**
     * Returns parameters for redirectURL
     *
     * @param $params
     *
     * @return array
     */
    public function cleanUrlParams($params)
    {
        $requestParams = [];
        foreach ($params as $key => $value) {
            if (!is_null($value) && !array_key_exists($key, $this::paramexcludes)) {
                $requestParams[$key] = $value;
            }
        }
        return $requestParams;
    }

    /**
     * @return array
     */
    public function getKlarnaOrderRequestParams()
    {
        return $this->klarnaOrderRequestParams;
    }

    /**
     * @return CTResponse
     */
    public function requestSession()
    {
        $requestType = 'KLARNA_SESSION';
        $params = $this->getKlarnaSessionRequestParams();
        $ctRequest = $this->cleanUrlParams($params);


        $response = $this->request($requestType, $ctRequest);

        return $response;
    }

    /**
     * @return CTResponse
     */
    public function requestKlarnaCreateOrder()
    {
        $requestType = 'KLARNA_ORDER (CNO)';
        $params = $this->getKlarnaOrderRequestParams();
        $ctRequest = $this->cleanUrlParams($params);

        $response = $this->request($requestType, $ctRequest);

        return $response;
    }

    /**
     * @return CTResponse
     */
    public function requestKlarnaRefNrChange()
    {
        $requestType = 'KLARNA_REF_NR_CHANGE (UMR)';
        $params = $this->getKlarnaRefNrChangeRequestParams();
        $ctRequest = $this->cleanUrlParams($params);

        $response = $this->request($requestType, $ctRequest);

        return $response;
    }

    /**
     * @return CTResponse
     */
    public function requestKlarnaUpdateArticleList()
    {
        $requestType = 'KLARNA_UPDATE_ARTICLE_LIST (UEO)';
        $params = $this->getKlarnaUpdateArtikelListRequestParams();
        $ctRequest = $this->cleanUrlParams($params);

        $response = $this->request($requestType, $ctRequest);

        return $response;
    }

    /**
     * @return CTResponse
     */
    public function requestKlarnaChangeBillingShipping()
    {
        $requestType = 'KLARNA_CHANGE_BILLING_SHIPPING (UCA)';
        $params = $this->getKlarnaChangeBillingShippingRequestParams();
        $ctRequest = $this->cleanUrlParams($params);

        $response = $this->request($requestType, $ctRequest);

        return $response;
    }

    /**
     * @param $requestType
     * @param $requestParams
     *
     * @return CTResponse
     */
    public function request($requestType, $requestParams)
    {
        $CTPaymentURL = $this->getCTPaymentURL();
        $ctRequest = $this->cleanUrlParams($requestParams);
        $response = null;

        /** @var FatchipCTPayment $plugin */
        $plugin = Shopware()->Container()->get('plugins')->Frontend()->FatchipCTPayment();
        $response = $plugin->callComputopService($ctRequest, $this, $requestType, $CTPaymentURL);

        return $response;
    }
}

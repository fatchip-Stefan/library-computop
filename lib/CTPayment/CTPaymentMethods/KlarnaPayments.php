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

use Fatchip\CTPayment\CTPaymentMethod;

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
    public function __construct(
        $config
    )
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
     *
     * @return array
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
     * @return string
     */
    public function getKlarnaSessionRequestParamsHash()
    {
        $hashable = [
            'TaxAmount' => $this->klarnaSessionRequestParams['TaxAmount'],
            'ArticleList' => $this->klarnaSessionRequestParams['ArticleList'],
            'PayType' => $this->klarnaSessionRequestParams['PayType'],
            'bdCountryCode' => $this->klarnaSessionRequestParams['bdCountryCode'],
            'amount' => $this->klarnaSessionRequestParams['amount'],
            'currency' => $this->klarnaSessionRequestParams['currency'],
            'IPAddr' => $this->klarnaSessionRequestParams['IPAddr'],
        ];

        return md5(serialize($hashable));
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
}

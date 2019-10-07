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
 * Class AmazonPay
 * @package Fatchip\CTPayment\CTPaymentMethods
 */
class KlarnaPayments extends CTPaymentMethod
{
    const paymentClass = 'KlarnaPayments';

    protected $klarnaSessionRequestParams;
    protected $klarnaOrderRequestParams;
    protected $klarnaRefNrChangeRequestParams;

    /**
     * AmazonPay constructor
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
     * returns RefNrChangeURL, used to set the refNr for a transaction in CT-Analytics
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
     * sets and returns request parameters for reference number change api call
     *
     * @param $payId
     * @param $refNr
     * @return array
     */
    public function getRefNrChangeParams($payId, $refNr)
    {
        $eventToken = 'UMR';

        $this->storeKlarnaRefNrChangeRequestParams($payId, $eventToken, $refNr);

        return $this->klarnaRefNrChangeRequestParams;
    }

    /**
     * returns PaymentURL
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
     * @return mixed
     */
    public function getKlarnaSessionRequestParams()
    {
        return $this->klarnaSessionRequestParams;
    }

    /**
     * @return mixed
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
     * returns parameters for redirectURL
     * @param $params
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
     * @return mixed
     */
    public function getKlarnaOrderRequestParams()
    {
        return $this->klarnaOrderRequestParams;
    }
}

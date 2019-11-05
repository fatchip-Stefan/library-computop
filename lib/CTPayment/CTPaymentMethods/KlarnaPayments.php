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
use Fatchip\CTPayment\CTResponse;
use Shopware_Plugins_Frontend_FatchipCTPayment_Bootstrap as FatchipCTPayment;

/**
 * @package Fatchip\CTPayment\CTPaymentMethods
 */
class KlarnaPayments extends CTPaymentMethod
{
    use \Fatchip\CTPayment\CTHelper\KlarnaPayments;

    const paymentClass = 'KlarnaPayments';

    /** @var array */
    protected $klarnaSessionRequestParams;
    /** @var array */
    protected $klarnaOrderRequestParams;

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
     * Returns RefNrChangeURL, used to set the refNr for a transaction in CT-Analytics
     *
     * @return string
     */
    public function getCTRefNrChangeURL()
    {
        return 'https://www.computop-paygate.com/KlarnaPayments.aspx';
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
        $params = [
            'payID' => $payId,
            'EventToken' => 'UMR',
            'RefNr' => $refNr,
        ];

        return $params;
    }

    /**
     * @param $payId
     * @param $transId
     * @param $amount
     * @param $currency
     * @param $tokenExt
     * @return array
     */
    public function getKlarnaOrderRequestParams(
        $payId,
        $transId,
        $amount,
        $currency,
        $tokenExt
    )
    {
        $params = [
            'payID' => $payId,
            'transID' => $transId,
            'amount' => $amount,
            'currency' => $currency,
            'TokenExt' => $tokenExt,
            'EventToken' => 'CNO'
        ];

        return $params;
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
            'IPAddr' => $ipAddress
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
     * @param $requestType
     * @param $requestParams
     *
     * @return CTResponse
     */
    public function request($requestType, $requestParams)
    {
        $CTPaymentURL = $this->getCTPaymentURL();
        $ctRequest = $this->cleanUrlParams($requestParams);

        /** @var FatchipCTPayment $plugin */
        $plugin = Shopware()->Container()->get('plugins')->Frontend()->FatchipCTPayment();
        $response = $plugin->callComputopService($ctRequest, $this, $requestType, $CTPaymentURL);

        return $response;
    }
}

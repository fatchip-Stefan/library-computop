<?php

namespace Fatchip\CTPayment\CTPaymentMethods;

use Fatchip\CTPayment\CTPaymentMethod;

class AmazonPay extends CTPaymentMethod
{
    const paymentClass = 'AmazonPay';



    public function __construct(
        $config
    )
    {
        $this->merchantID = $config['merchantID'];
        $this->blowfishPassword = $config['blowfishPassword'];
        $this->mac = $config['mac'];
    }


    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/AmazonAPA.aspx';
    }

    public function getAmazonLGNParams($transID, $accessToken, $tokenType, $expiry, $scope, $countryCode, $urlNotify)
    {
        $params = [
            'merchantID' => $this->merchantID,
            'transID' => $transID,
            'CountryCode' => $countryCode,
            'URLNotify' => $urlNotify,
            'AccessToken' => $accessToken,
            'TokenType' => $tokenType,
            'Expiry' => $expiry,
            'Scope' => $scope,
            'EventToken' => 'LGN',
        ];

        return $params;
    }

    public function getAmazonSODParams($payID, $transID, $amount, $currency, $orderDesc, $referenceID)
    {
        $params = [
            'payID' => $payID,
            'merchantID' => $this->merchantID,
            'transID' => $transID,
            'amount' => $amount,
            'currency' => $currency,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'SOD',
        ];

        return $params;
    }

    public function getAmazonGODParams($payID, $orderDesc, $referenceID)
    {
        $params = [
            'payID' => $payID,
            'merchantID' => $this->merchantID,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'GOD',
        ];

        return $params;
    }

    public function getAmazonSCOParams($payID, $transID, $amount, $currency, $orderDesc, $referenceID)
    {
        $params = [
            'payID' => $payID,
            'merchantID' => $this->merchantID,
            'transID' => $transID,
            'amount' => $amount,
            'currency' => $currency,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'SCO',
        ];

        return $params;
    }
}

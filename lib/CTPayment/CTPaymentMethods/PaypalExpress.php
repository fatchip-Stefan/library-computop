<?php

namespace Fatchip\CTPayment\CTPaymentMethods;

use Fatchip\CTPayment\CTPaymentMethod;

class PaypalExpress extends CTPaymentMethod
{
    const paymentClass = 'PaypalExpress';

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
        return 'https://www.computop-paygate.com/paypalComplete.aspx';
    }

    public function getPaypalExpressCompleteParams($payID, $transID, $amount, $currency, $orderDesc)
    {
        $params = [
            'PayID' => $payID,
            'MerchantID' => $this->merchantID,
            'TransID' => $transID,
            'Amount' => $amount,
            'Currency' => $currency,
        ];

        return $params;
    }
}

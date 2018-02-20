<?php

namespace Fatchip\CTPayment;

class CTAmazon extends Blowfish
{
    public function __construct(
        $config
    )
    {
        $this->merchantID = $config['merchantID'];
        $this->blowfishPassword = $config['blowfishPassword'];
        $this->mac = $config['mac'];
    }

    public function prepareComputopRequest($params)
    {
        $requestParams = [];
        foreach ($params as $key => $value) {
            $requestParams[] = "$key=" . $value;
        }
        $requestParams[] = "MAC=" . $this->ctHMAC($params);
        $request = join('&', $requestParams);
        $len = strlen($request);  // Length of the plain text string
        $data = $this->ctEncrypt($request, $len, $this->blowfishPassword);

        return 'https://www.computop-paygate.com/AmazonAPA.aspx' .
            '?MerchantID=' . $this->merchantID .
            '&Len=' . $len .
            '&Data=' . $data;
    }

    public function getAmazonLGNParams($transID, $accessToken, $tokenType, $expiry, $scope, $countryCode, $urlNotify)
    {
        $params = [
            'MerchantID' => $this->merchantID,
            'TransID' => $transID,
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
            'PayID' => $payID,
            'MerchantID' => $this->merchantID,
            'TransID' => $transID,
            'Amount' => $amount,
            'Currency' => $currency,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'SOD',
        ];

        return $params;
    }

    public function getAmazonGODParams($payID, $orderDesc, $referenceID)
    {
        $params = [
            'PayID' => $payID,
            'MerchantID' => $this->merchantID,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'GOD',
        ];

        return $params;
    }

    public function getAmazonSCOParams($payID, $transID, $amount, $currency, $orderDesc, $referenceID)
    {
        $params = [
            'PayID' => $payID,
            'MerchantID' => $this->merchantID,
            'TransID' => $transID,
            'Amount' => $amount,
            'Currency' => $currency,
            'OrderDesc' => $orderDesc,
            'OrderReferenceID' => $referenceID,
            'EventToken' => 'SCO',
        ];

        return $params;
    }

    private function ctHMAC($params)
    {
        $data = $params['PayID'].'*'.$params['TransID'].'*'.$params['MerchantID'].'*'.$params['Amount'].'*'.$params['Currency'];
        return hash_hmac("sha256", $data, $this->mac);
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

    public function callComputopAmazon($ctRequest)
    {
        $curl = curl_init();

        curl_setopt_array($curl,
            [ CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->prepareComputopRequest($ctRequest)
            ]);
        try {
            $resp = curl_exec($curl);

            if (FALSE === $resp) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }

        } catch (\Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
        $arr = [];
        parse_str($resp, $arr);
        $plaintext = $this->ctDecrypt($arr['Data'], $arr['Len'], $this->blowfishPassword);

        return ($this->ctSplit(explode('&', $plaintext), '='));
    }
}

<?php

namespace Fatchip\CTPayment;

abstract class CTPaymentMethod extends Blowfish
{


    /**
     * Vom Paygate vergebene ID für die Zahlung. Z.B. zur Referenzierung in Batch-Dateien.
     *
     * @var string
     */
    protected $payID;

    /**
     * @param string $PayID
     */
    public function setPayID($PayID)
    {
        $this->payID = $PayID;
    }

    /**
     * @return string
     */
    public function getPayID()
    {
        return $this->payID;
    }

    protected function ctHMAC($params)
    {
        $data = $params['payID'].'*'.$params['transID'].'*'.$this->merchantID.'*'.$params['amount'].'*'.$params['currency'];
        return hash_hmac("sha256", $data, $this->mac);
    }

    public function prepareComputopRequest($params, $url)
    {
        $requestParams = [];
        foreach ($params as $key => $value) {
            $requestParams[] = "$key=" . $value;
        }
        $requestParams[] = "MAC=" . $this->ctHMAC($params);
        $request = join('&', $requestParams);
        $len = mb_strlen($request);  // Length of the plain text string
        $data = $this->ctEncrypt($request, $len, $this->blowfishPassword);

        return $url .
            '?MerchantID=' . $this->merchantID .
            '&Len=' . $len .
            '&Data=' . $data;
    }

    public function callComputop($ctRequest, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl,
            [ CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $this->prepareComputopRequest($ctRequest, $url)
            ]);
        try {
            $resp = curl_exec($curl);

            if (false === $resp) {
                throw new \Exception(curl_error($curl), curl_errno($curl));
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
        $response = new CTResponse($this->ctSplit(explode('&', $plaintext), '='));
        return $response;
    }

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getCTCaptureURL()
    {
        return 'https://www.computop-paygate.com/capture.aspx';
    }

    public function getCTInquireURL() {
        return 'https://www.computop-paygate.com/inquire.aspx';
    }

    public function getCTRefNrChangeURL() {
        return 'https://www.computop-paygate.com/RefNrChange.aspx';
    }

    public function getRefundParams($PayID, $Amount, $Currency, $transID = null, $xID = null, $orderDesc = null, $klarnaInvNo = null) {
        $params = [
            'payID' => $PayID,
            'amount' => $Amount,
            'currency' => $Currency,
            // used by easyCredit
            'Date' =>  date("Y-m-d"),
            // used by amazonpay
            'transID' => $transID,
            'xID' => $xID,
            //used by klarna
            'orderDesc' => $orderDesc,
            'invNo' => $klarnaInvNo,
        ];

        return $params;
    }

    public function getCaptureParams($PayID, $Amount, $Currency, $transID = null, $xID = null, $orderDesc = null) {
        $params = [
            'payID' => $PayID,
            'amount' => $Amount,
            'currency' => $Currency,
            // used by easyCredit
            'Date' =>  date("Y-m-d"),
            // used by amazonpay
            'transID' => $transID,
            'xID' => $xID,
            //used by klarna
            'orderDesc' => $orderDesc,
        ];

        return $params;
    }

    public function getInquireParams($PayID) {
        $params = [
            'payID' => $PayID,
        ];

        return $params;
    }

    public function getRefNrChangeParams($PayID, $RefNr) {
        $params = [
          'payID' => $PayID,
          'RefNr' => $RefNr,
        ];

        return $params;
    }
}

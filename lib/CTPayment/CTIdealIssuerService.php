<?php

namespace Fatchip\CTPayment;

class CTIdealIssuerService extends Blowfish
{

    public function __construct(
        $config
    ) {
        $this->merchantID = $config['merchantID'];
        $this->blowfishPassword = $config['blowfishPassword'];
        $this->mac = $config['mac'];
    }

    public function getIssuerListURL()
    {
        $queryarray = [
            'MerchantID=' . $this->merchantID,
            'MAC=' . $this->ctHMAC(),
    ]
                        ;

        $query = join("&", $queryarray);

        $len = strlen($query);  // Length of the plain text string
        $data = $this->ctEncrypt($query, $len, $this->blowfishPassword);

        $test = 'https://www.computop-paygate.com/idealIssuerList.aspx' .
            '?MerchantID=' . $this->merchantID .
            '&Len=' . $len .
            '&Data=' . $data
        ;
        return 'https://www.computop-paygate.com/idealIssuerList.aspx' .
               '?MerchantID=' . $this->merchantID .
               '&Len=' . $len .
               '&Data=' . $data
        ;
    }

    protected function ctHMAC()
    {
        return hash_hmac(
            "sha256",
            "$this->merchantID",
            $this->mac
        );
    }

    public function getIssuerList()
    {
        /* does not work, for testing just update with static array)
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->getIssuerListURL(),
        ));

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

        $arr = array();
        parse_str($resp, $arr);
        $plaintext = $this->ctDecrypt($arr['Data'], $arr['Len'], $this->blowfishPassword);

        return $arr;
        */

        $issuerList = [
            [
                'issuerId' => 'ABNANL2A',
                'name' => 'ABN AMRO',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'ASNBNL21',
                'name' => 'ASN Bank',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'BUNQNL2A',
                'name' => 'Bunq',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'INGBNL2A',
                'name' => 'INGING',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'KNABNL2H',
                'name' => 'Knab',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'RABONL2U',
                'name' => 'Rabo',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'RBRBNL21',
                'name' => 'RegioBank',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'SNSBNL2A',
                'name' => 'SNS Bank',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'TRIONL2U',
                'name' => 'Triodos Bank',
                'land' => 'DE',
            ],
            [
                'issuerId' => 'FVLBNL22',
                'name' => 'van Lanschot',
                'land' => 'DE',
            ],


        ];

        return $issuerList;
    }
}

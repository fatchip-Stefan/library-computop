<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class Sofort extends CTPaymentMethodIframe
{
    /**
     * „Ident“ für Sofort Ident oder „ideal“ für Sofort iDEAL
     * Ident müssen wir nicht implementieren, macht nur identification
     *
     * @var string
     */
    protected $sofortAction = '';

    /**
     * ID der Bank, über die iDEAL-Überweisungen erfolgen sollen;
     * Pflicht bei So-fortaction=ideal
     * Folgende IssuerIDs sind verfügbar:
     * RABONL2U - Rabobank
     * INGBNL2A - ING
     * ABNANL2A - ABN Amro
     * ASNBNL21 - ASN Bank
     * SNSBNL2A - SNS Bank
     * RBRBNL21 - Regiobank
     * TRIONL2U - Triodos Bank
     * FVLBNL22 - Van Lanschot Bankiers
     * KNABNL2H - Knab
     * BUNQNL2A - bunq
     *
     * @var string
     */
    protected $issuerID; //Bic der ausgewählten Bank

    /**
     * Ländercode zweistellig gemäß ISO 3166.
     * Derzeit DE, AT, BE, NL, ES, CH, PL, IT zulässig.
     *
     * @var string
     */
    protected $addrCountryCode;

    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);
        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);
        $this->setAddrCountryCode($order->getBillingAddress()->getCountryCode());
        $this->setMandatoryFields(array('merchantID', 'transID', 'amount', 'currency', 'orderDesc', 'addrCountryCode',
          'mac', 'urlSuccess', 'urlFailure', 'urlNotify', ));
    }


    /**
     * @param string $sofortAction
     */
    public function setSofortAction($sofortAction)
    {
        $this->sofortAction = $sofortAction;
    }

    /**
     * @return string
     */
    public function getSofortAction()
    {
        return $this->sofortAction;
    }


    /**
     * @param string $issuerID
     */
    public function setIssuerID($issuerID)
    {
        $this->issuerID = $issuerID;
    }

    /**
     * @return string
     */
    public function getIssuerID()
    {
        return $this->issuerID;
    }

    /**
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode)
    {
        $this->addrCountryCode = $addrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode()
    {
        return $this->addrCountryCode;
    }

    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/sofort.aspx';
    }

    public function getCTRefundURL()
    {
        return 'https://www.computop-paygate.com/credit.aspx';
    }

    public function getSettingsDefinitions()
    {
        return 'Sofort oder SofortIdent';
    }
}

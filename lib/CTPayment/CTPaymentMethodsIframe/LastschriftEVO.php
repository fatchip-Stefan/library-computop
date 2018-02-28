<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class LastschriftEVO extends Lastschrift
{
    /**
     * 2. Zeile der Warenbeschreibung, die auf dem Kontoauszug erscheint (27 Zei-chen).
     *
     * @var string
     */
    public $orderDesc2;

     /**
     * für SEPA: Anzahl Banktage>0, die für das Ausführungsdatum einer Lastschrift zum aktuellen Datum addiert werden
     *
     * @var int
     */
    public $DebitDelay;

    /**
     * @param $amount
     * @param $currency
     * @param $urlSuccess
     * @param $urlFailure
     * @param $urlNotify
     * @param $orderDesc
     * @param $userData
     */

    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData,
        $capture,
        $orderDesc2
    ) {
        parent::__construct($config, $order, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData, $capture);
        $this->setOrderDesc2($orderDesc2);
    }

    /**
     * @param string $orderDesc2
     */
    public function setOrderDesc2($orderDesc2)
    {
        $this->orderDesc2 = $orderDesc2;
    }

    /**
     * @param string $orderDesc2
     */
    public function setDebitDelay($debitDelay)
    {
        $this->DebitDelay = $debitDelay;
    }

    /**
     * @return string
     */
    public function getOrderDesc2()
    {
        return $this->orderDesc2;
    }


}

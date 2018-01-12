<?php

namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

class LastschriftDirekt extends Lastschrift
{
    /**
     * 2. Zeile der Warenbeschreibung, die auf dem Kontoauszug erscheint (27 Zei-chen).
     *
     * @var string
     */
    protected $orderDesc2;


    /**
     * @param $amount
     * @param $currency
     * @param $urlSuccess
     * @param $urlFailure
     * @param $urlNotify
     * @param $OrderDesc
     * @param $UserData
     */

    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $OrderDesc,
        $UserData,
        $capture,
        $orderDesc2
    ) {
        parent::__construct($config, $order, $urlSuccess, $urlFailure, $urlNotify, $OrderDesc, $UserData, $capture);
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
     * @return string
     */
    public function getOrderDesc2()
    {
        return $this->orderDesc2;
    }
}

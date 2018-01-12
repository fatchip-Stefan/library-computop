<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 01.12.17
 * Time: 15:12
 */


namespace Fatchip\CTPayment\CTResponse;

abstract class CTResponseIframe extends CTResponse
{
    /**
     * HändlerID, die von Computop vergeben wird
     *
     * @var string
     */
    protected $MID = null;

    /**
     * Vom Paygate vergebene ID für die Zahlung
     *
     * @var string
     */
    protected $PayID = null;


    /**
     * Vom Paygate vergebene ID für alle einzelnen Transaktionen (Autorisierung, Bu-chung, Gutschrift),
     * die für eine Zahlung durchgeführt werden
     *
     * @var string
     */
    protected $XID = null;


    /**
     * Transaktionsnummer des Händlers
     *
     * @var string
     */
    protected $TransID = null;

    /**
     * @param string $mid
     */
    public function setMID($mid)
    {
        $this->MID = $mid;
    }

    /**
     * @return string
     */
    public function getMID()
    {
        return $this->MID;
    }

    /**
     * @param string $payID
     */
    public function setPayID($payID)
    {
        $this->PayID = $payID;
    }

    /**
     * @return string
     */
    public function getPayID()
    {
        return $this->PayID;
    }

    /**
     * @param string $xid
     */
    public function setXID($xid)
    {
        $this->XID = $xid;
    }

    /**
     * @return string
     */
    public function getXID()
    {
        return $this->XID;
    }

    /**
     * @param string $transID
     */
    public function setTransID($transID)
    {
        $this->TransID = $transID;
    }

    /**
     * @return string
     */
    public function getTransID()
    {
        return $this->TransID;
    }
}

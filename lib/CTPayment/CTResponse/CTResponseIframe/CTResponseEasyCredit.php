<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:14
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

class CTResponseEasyCredit extends CTResponseIframe
{

    /**
     * @var string
     */
    protected $Desicion;

    /**
     * @var string
     */
    protected $Process;

    /**
     * @var string
     */
    protected $Financing;

    /**
     * Eindeutige Referenznummer (Optional)
     *
     * @var string
     */
    protected $RefNr;

    /**
     * @param string $desicion
     */
    public function setDesicion($desicion)
    {
        $this->Desicion = $desicion;
    }

    /**
     * Enthält die Entscheidungsdaten zur vorherigen Initialisie-rung.
     * Diese werden im JSON-Format und Base64-encodiert zurückgegeben     *
     *
     * @return string
     */
    public function getDesicion()
    {
        return  base64_decode($this->Desicion);
    }

    /**
     * @param string $financing
     */
    public function setFinancing($financing)
    {
        $this->Financing = $financing;
    }

    /**
     * @return string
     */
    public function getFinancing()
    {
        return base64_decode($this->Financing);
    }

    /**
     * @param string $process
     */
    public function setProcess($process)
    {
        $this->Process = $process;
    }

    /**
     * @return string
     */
    public function getProcess()
    {
        return base64_decode($this->Process);
    }

    /**
     * @param string $refNr
     */
    public function setRefNr($refNr)
    {
        $this->RefNr = $refNr;
    }

    /**
     * @return string
     */
    public function getRefNr()
    {
        return $this->RefNr;
    }



    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }
}

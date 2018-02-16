<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:21
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

class CTResponseKlarna extends CTResponseIframe
{

    /**
     * Reservierungsnummer: wird bei Reservierung (Autorisierung) zurückgegeben
     *
     * @var string
     */
    protected $Rno;

    /**
     * Rechnungsnummer: wird bei Aktivierung (Capture) zurückgegeben. Längste In-vNo bisher war 17-stellig.
     * Über folgende URL können Sie sich Packing Slips bei Klarna herunterladen:
     * https://online.klarna.com/packslips/{InvNo}.pdf
     *
     * @var string
     */
    protected $InvNo;

    /**
     * @return string
     */
    public function getRno()
    {
        return $this->Rno;
    }

    /**
     * @param string $Rno
     */
    public function setRno($Rno)
    {
        $this->Rno = $Rno;
    }

    /**
     * @return string
     */
    public function getInvNo()
    {
        return $this->InvNo;
    }

    /**
     * @param string $InvNo
     */
    public function setInvNo($InvNo)
    {
        $this->InvNo = $InvNo;
    }
}

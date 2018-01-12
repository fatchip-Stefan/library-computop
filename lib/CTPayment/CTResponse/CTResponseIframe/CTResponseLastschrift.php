<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:27
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

abstract class CTResponseLastschrift extends CTResponseIframe
{
    protected $Type;

    protected $IBAN;

    protected $BIC;

    protected $AccOwner;

    protected $Mandateid;

    protected $Dtofsgntr;

    protected $Mdtseqtype;

    /**
     * @param mixed $accOwner
     */
    public function setAccOwner($accOwner)
    {
        $this->AccOwner = $accOwner;
    }

    /**
     * @return mixed
     */
    public function getAccOwner()
    {
        return $this->AccOwner;
    }

    /**
     * @param mixed $bic
     */
    public function setBIC($bic)
    {
        $this->BIC = $bic;
    }

    /**
     * @return mixed
     */
    public function getBIC()
    {
        return $this->BIC;
    }

    /**
     * @param mixed $dtofsgntr
     */
    public function setDtofsgntr($dtofsgntr)
    {
        $this->Dtofsgntr = $dtofsgntr;
    }

    /**
     * @return mixed
     */
    public function getDtofsgntr()
    {
        return $this->Dtofsgntr;
    }

    /**
     * @param mixed $iban
     */
    public function setIBAN($iban)
    {
        $this->IBAN = $iban;
    }

    /**
     * @return mixed
     */
    public function getIBAN()
    {
        return $this->IBAN;
    }

    /**
     * @param mixed $mandateId
     */
    public function setMandateid($mandateId)
    {
        $this->Mandateid = $mandateId;
    }

    /**
     * @return mixed
     */
    public function getMandateid()
    {
        return $this->Mandateid;
    }

    /**
     * @param mixed $mdtseqtype
     */
    public function setMdtseqtype($mdtseqtype)
    {
        $this->Mdtseqtype = $mdtseqtype;
    }

    /**
     * @return mixed
     */
    public function getMdtseqtype()
    {
        return $this->Mdtseqtype;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->Type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }



    public function __construct(array $params = array())
    {
        parent::__construct($params);
    }
}

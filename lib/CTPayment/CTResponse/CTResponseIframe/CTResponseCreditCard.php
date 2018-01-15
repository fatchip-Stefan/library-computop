<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:11
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

class CTResponseCreditCard extends CTResponseIframe
{

    /**
     * Bei 3D Secure nur in der Antwort an URLNotify: Kürzel zur Typisierung der Zah-lung, z.B. SSL
     *
     * @var string
     */
    protected $Type;

    /**
     * Pseudo Card Number: Vom Paygate generierte Zufallszahl, die eine reale Kre-ditkartennummer repräsentiert.
     * Die Pseudokartennummer (PKN) beginnt mit 0, und die letzten 3 Stellen entsprechen denen der realen Kartennummer.
     * Die PKN können Sie wie eine reale Kartennummer für Autorisierung, Buchung und Gutschriften verwenden
     *
     * @var int
     */
    protected $PCNr;

    /**
     * In Verbindung mit pcNr: Ablaufdatum der Kreditkarte im Format YYYYMM
     *
     * @var int
     */
    protected $CCExpiry;

    /**
     * In Verbindung mit pcNr: Bezeichnung der Kreditkartenmarke
     * Bitte beachten Sie die Schreibweise gemäß Tabelle der Kreditkartenmarken!
     *
     * @var string
     */
    protected $CCBrand;

    /**
     * @param string $ccBrand
     */
    public function setCCBrand($ccBrand)
    {
        $this->CCBrand = $ccBrand;
    }

    /**
     * @return string
     */
    public function getCCBrand()
    {
        return $this->CCBrand;
    }

    /**
     * @param int $ccExpiry
     */
    public function setCCExpiry($ccExpiry)
    {
        $this->CCExpiry = $ccExpiry;
    }

    /**
     * @return int
     */
    public function getCCExpiry()
    {
        return $this->CCExpiry;
    }

    /**
     * @param int $pcNr
     */
    public function setPCNr($pcNr)
    {
        $this->PCNr = $pcNr;
    }

    /**
     * @return int
     */
    public function getPCNr()
    {
        return $this->PCNr;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->Type = $type;
    }

    /**
     * @return string
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

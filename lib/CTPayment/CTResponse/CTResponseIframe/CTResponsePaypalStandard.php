<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:47
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

class CTResponsePaypalStandard extends CTResponseIframe
{
    /**
     * Eindeutige Transaktionsnummer bei PayPal
     *
     * @var string
     */
    protected $TransactionID;

    /**
     * Nachricht an den Händler
     *
     * @var string
     */
    protected $InfoText;

    /**
     * Vorname und Nachname zusammengenommen
     *
     * @var string
     */
    protected $name;

    /**
     * Vorname vom Bezahler (PayerInfo, kann vom Account-Namen abweichen)
     *
     * @var string
     */
    protected $FirstName;

    /**
     * Nachname vom Bezahler (PayerInfo, kann vom Account-Namen abweichen)
     *
     * @var string
     */
    protected $LastName;

    /**
     * E-Mail-Adresse des Käufers.
     *
     * @var string
     */
    protected $EMail;

    /**
     * Straßenname der Lieferadresse
     *
     * @var string
     */
    protected $AddrStreet;

    /**
     * 2. Straßenname der Lieferadresse, wenn mit Computop abgestimmt
     *
     * @var string
     */
    protected $AddrStreet2;

    /**
     * Ortsname der Lieferadresse
     *
     * @var string
     */
    protected $AddrCity;

    /**
     * Bundesland (Bundesstaat) der Lieferadresse
     *
     * @var string
     */
    protected $AddrState;

    /**
     * Postleitzahl der Lieferadresse
     *
     * @var string
     */
    protected $AddrZIP;

    /**
     * Ländercode des Lieferlandes
     *
     * @var string
     */
    protected $AddrCountryCode;

    /**
     * Identifikationsnummer der Rechnungsvereinbarung. Wenn der Käufer die Rech-nungsvereinbarung bestätigt,
     * wird sie gültig und bleibt gültig, bis sie vom Käufer widerrufen wird.
     *
     * @var string
     */
    protected $BillingAgreementiD;

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity)
    {
        $this->AddrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity()
    {
        return $this->AddrCity;
    }

    /**
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode)
    {
        $this->AddrCountryCode = $addrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode()
    {
        return $this->AddrCountryCode;
    }

    /**
     * @param string $addrState
     */
    public function setAddrState($addrState)
    {
        $this->AddrState = $addrState;
    }

    /**
     * @return string
     */
    public function getAddrState()
    {
        return $this->AddrState;
    }

    /**
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet)
    {
        $this->AddrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet()
    {
        return $this->AddrStreet;
    }

    /**
     * @param string $addrStreet2
     */
    public function setAddrStreet2($addrStreet2)
    {
        $this->AddrStreet2 = $addrStreet2;
    }

    /**
     * @return string
     */
    public function getAddrStreet2()
    {
        return $this->AddrStreet2;
    }

    /**
     * @param string $addrZIP
     */
    public function setAddrZIP($addrZIP)
    {
        $this->AddrZIP = $addrZIP;
    }

    /**
     * @return string
     */
    public function getAddrZIP()
    {
        return $this->AddrZIP;
    }

    /**
     * @param string $billingAgreementiD
     */
    public function setBillingAgreementiD($billingAgreementiD)
    {
        $this->BillingAgreementiD = $billingAgreementiD;
    }

    /**
     * @return string
     */
    public function getBillingAgreementiD()
    {
        return $this->BillingAgreementiD;
    }

    /**
 * @param string $eMail
 */
    public function setEMail($eMail)
    {
        $this->EMail = $eMail;
    }



    /**
     * @return string
     */
    public function getEMail()
    {
        return $this->EMail;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->FirstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @param string $infoText
     */
    public function setInfoText($infoText)
    {
        $this->InfoText = $infoText;
    }

    /**
     * @return string
     */
    public function getInfoText()
    {
        return $this->InfoText;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param string $transactionID
     */
    public function setTransactionID($transactionID)
    {
        $this->TransactionID = $transactionID;
    }

    /**
     * @return string
     */
    public function getTransactionID()
    {
        return $this->TransactionID;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

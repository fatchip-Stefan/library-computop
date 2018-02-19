<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 01.12.17
 * Time: 14:58
 */

namespace Fatchip\CTPayment\CTResponse;

use Fatchip\CTPayment\CTResponse\datetime;

class CTResponse
{

  /**
   * OK oder AUTHORIZED (URLSuccess) sowie FAILED (URLFailure)
   *
   * @var string
   */
    protected $status = null;

    /**
     * @var string
     */
    protected $rawResponse = null;

    /**
     * Nähere Beschreibung bei Ablehnung der Zahlung.
     * Bitte nutzen Sie nicht den Parameter description sondern code für die Auswertung des Transaktionssta-tus!
     *
     * @var string
     */
    protected $Description = null;


    /**
     * Fehlercode gemäß Excel-Datei Paygate Antwort Codes
     *
     * @var int
     */
    protected $Code = null;


    /**
     * Hash Message Authentication code (HMAC) mit SHA-256-Algorithmus
     *
     * @var string
     */
    protected $MAC = null;


    /**
     * Wenn beim Aufruf angegeben, übergibt das Paygate die Parameter mit dem Zahlungsergebnis an den Shop
     *
     * @var string
     */
    protected $UserData;
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
     * @var string
     */
    protected $Decision;
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
     * Klarna
     * Reservierungsnummer: wird bei Reservierung (Autorisierung) zurückgegeben
     *
     * @var string
     */
    protected $RNo;
    /**
     * Klarna
     * Rechnungsnummer: wird bei Aktivierung (Capture) zurückgegeben. Längste In-vNo bisher war 17-stellig.
     * Über folgende URL können Sie sich Packing Slips bei Klarna herunterladen:
     * https://online.klarna.com/packslips/{InvNo}.pdf
     *
     * @var string
     */
    protected $InvNo;
    /**
     * for Lastschrift
     * @var
     */
    protected $IBAN;
    /**
     * for Lastschrift
     * @var
     */
    protected $BIC;
    /**
     * for Lastschrift
     * @var
     */
    protected $AccOwner;
    /**
     * for Lastschrift
     * @var
     */
    protected $Mandateid;
    /**
     * for Lastschrift
     * @var
     */
    protected $Dtofsgntr;
    /**
     * for Lastschrift
     * @var
     */
    protected $Mdtseqtype;
    /**
     * Eindeutige ID des Vorgangs bei paydirekt
     *
     * @var string
     */
    protected $Reference;
    /**
     * Vorname in der Lieferanschrift
     *
     * @var string
     */
    protected $sdFirstName;
    /**
     * Nachname in der Lieferanschrift
     *
     * @var string
     */
    protected $sdLastName;
    /**
     * Straßenname in der Lieferanschrift
     *
     * @var string
     */
    protected $sdStreet;
    /**
     * Hausnummer in der Lieferanschrift
     *
     * @var string
     */
    protected $sdStreetNr;
    /**
     * Postleitzahl in der Lieferanschrift
     *
     * @var string
     */
    protected $sdZip;
    /**
     * Ort in der Lieferanschrift
     *
     * @var string
     */
    protected $sdCity;
    /**
     * Ländercode in der Lieferanschrift
     *
     * @var string
     */
    protected $sdCountryCode;
    /**
     * E-Mail-Adresse des Empfängers
     *
     * @var string
     */
    protected $sdEmail;
    /**
     * Eindeutige Identifikation des Vorgangs und aller dazugehörigen Transaktionen bei paydirekt.
     * Diese ID ist vorhanden, sobald sich ein Kunde auf der Checkout-Seite eingeloggt hat.
     *
     * @var string
     */
    protected $TID;
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
     * Postfinance
     *
     * Zahlungszweck
     *
     * @var string
     */
    protected $PaymentPurpose;
    /**
     * Postfinance
     * Dieser Parameter wird nur zurückgegeben, falls der Status=OK ist.
     *
     * NONE = keine Zahlungsgarantie
     * VALIDATED = Kundenkonto valide, aber keine Zahlungsgarantie
     * FULL = Zahlungsgarantie Hinweis:
     *
     * @var string
     */
    protected $PaymentGuarantee;
    /**
     * Postfinance
     * Name des Kontoinhabers
     *
     * @var string
     */
    protected $AccNr;
    /**
     * @var string
     */
    protected $AccIBAN;
    /**
     * @var string
     */
    protected $AccBank;
    /**
     * Geldeingang laut Sofort
     * <1> gewährleistet,
     * <0> nicht gewährleistet.
     * Bitte war-ten Sie bei 0 auf den Geldeingang, bevor Sie die Ware verschicken.
     *
     * @var int
     */
    protected $SecCriteria;
    /**
     * nur bei Sofort Ident: Geburtsdatum
     *
     * @var datetime
     */
    protected $Birthday;
    /**
     * nur im Erfolgsfall bei Sofort Ident: Alter
     *
     * @var int
     */
    protected $Age;
    protected $AddrStreetNr;
    /**
     *
     * Handlungsempfehlung (Ampel): GREEN, YELLOW, RED, NO RESULT
     *
     * @var string
     */
    protected $result;
    protected $partialResults;
    /***
     * Inquire: amount authorized for order
     * @var AmountAuth
     */
    protected $AmountAuth;
    /***
     * Inquire: Amount Captured for order
     * @var AmountCap
     */
    protected $AmountCap;
    /***
     * Inquire: Amount credited for order
     *
     * @var AmountCred
     */
    protected $AmountCred;


    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        if (count($params) > 0) {
            $this->init($params);
        }
    }

    /**
     * @param array $data
     */
    public function init(array $data = array())
    {
        foreach ($data as $key => $value) {
            $key = ucwords(str_replace('_', ' ', $key));
            $method = 'set' . str_replace(' ', '', str_replace('-', '', $key));


            if (method_exists($this, $method)) {
                $this->{$method}($value);
            } else {
                $debug = 1;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = array();
        foreach ($this as $key => $data) {
            if ($data === null) {
                continue;
            } else {
                $result[$key] = $data;
            }
        }

        return $result;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->Code = $code;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->Description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $mac
     */
    public function setMAC($mac)
    {
        $this->MAC = $mac;
    }

    /**
     * @return string
     */
    public function getMAC()
    {
        return $this->MAC;
    }

    /**
     * @param string $userData
     */
    public function setUserData($userData)
    {
        $this->UserData = $userData;
    }

    /**
     * @return string
     */
    public function getUserData()
    {
        return $this->UserData;
    }




    /**
     * @param string $key
     * @return null|mixed
     */
    public function getValue($key)
    {
        return $this->get($key);
    }

    /**
     * @param string $key
     * @param string $name
     * @return boolean|null
     */
    public function setValue($key, $name)
    {
        return $this->set($key, $name);
    }

    /**
     * @param $name
     * @return null|mixed
     */
    protected function get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return boolean|null
     */
    protected function set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return true;
        }
        return null;
    }

    /**
     * @param $rawResponse
     */
    public function setRawResponse($rawResponse)
    {
        $this->rawResponse = $rawResponse;
    }
    /**
     * @return null
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    public function render()
    {
        $arr = get_object_vars($this);

        $result = '<table>';
        foreach ($arr as $name => $value) {
            $result .= '<tr><td>' . $name . '</td><td>' . $value . '</tr>';
        }
        $result .= '</table>';
        return $result;
    }

    /**
     * @param string $mid
     */
    public function setMID($mid) {
        $this->MID = $mid;
    }

    /**
     * @return string
     */
    public function getMID() {
        return $this->MID;
    }

    /**
     * @param string $payID
     */
    public function setPayID($payID) {
        $this->PayID = $payID;
    }

    /**
     * @return string
     */
    public function getPayID() {
        return $this->PayID;
    }

    /**
     * @param string $xid
     */
    public function setXID($xid) {
        $this->XID = $xid;
    }

    /**
     * @return string
     */
    public function getXID() {
        return $this->XID;
    }

    /**
     * @param string $transID
     */
    public function setTransID($transID) {
        $this->TransID = $transID;
    }

    /**
     * @return string
     */
    public function getTransID() {
        return $this->TransID;
    }

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
    public function getCCBrand() {
        return $this->CCBrand;
    }

    /**
     * @param int $ccExpiry
     */
    public function setCCExpiry($ccExpiry) {
        $this->CCExpiry = $ccExpiry;
    }

    /**
     * @return int
     */
    public function getCCExpiry() {
        return $this->CCExpiry;
    }

    /**
     * @param int $pcNr
     */
    public function setPCNr($pcNr) {
        $this->PCNr = $pcNr;
    }

    /**
     * @return int
     */
    public function getPCNr() {
        return $this->PCNr;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->Type = $type;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->Type;
    }

    /**
     * @param string $desicion
     */
    public function setDecision($desicion) {
        $this->Decision = $desicion;
    }

    /**
     * Enthält die Entscheidungsdaten zur vorherigen Initialisie-rung.
     * Diese werden im JSON-Format und Base64-encodiert zurückgegeben     *
     *
     * @return string
     */
    public function getDecision() {
        return base64_decode($this->Decision);
    }

    /**
     * @param string $financing
     */
    public function setFinancing($financing) {
        $this->Financing = $financing;
    }

    /**
     * @return string
     */
    public function getFinancing() {
        return base64_decode($this->Financing);
    }

    /**
     * @param string $process
     */
    public function setProcess($process) {
        $this->Process = $process;
    }

    /**
     * @return string
     */
    public function getProcess() {
        return base64_decode($this->Process);
    }

    /**
     * @param string $refNr
     */
    public function setRefNr($refNr) {
        $this->RefNr = $refNr;
    }

    /**
     * @return string
     */
    public function getRefNr() {
        return $this->RefNr;
    }

    /**
     * for Lastschrift
     * @param mixed $accOwner
     */
    public function setAccOwner($accOwner) {
        $this->AccOwner = $accOwner;
    }

    /**
     * @return mixed
     */
    public function getAccOwner() {
        return $this->AccOwner;
    }

    /**
     * @param mixed $bic
     */
    public function setBIC($bic) {
        $this->BIC = $bic;
    }

    /**
     * @return mixed
     */
    public function getBIC() {
        return $this->BIC;
    }

    /**
     * @param mixed $dtofsgntr
     */
    public function setDtofsgntr($dtofsgntr) {
        $this->Dtofsgntr = $dtofsgntr;
    }

    /**
     * @return mixed
     */
    public function getDtofsgntr() {
        return $this->Dtofsgntr;
    }

    /**
     * @param mixed $iban
     */
    public function setIBAN($iban) {
        $this->IBAN = $iban;
    }

    /**
     * @return mixed
     */
    public function getIBAN() {
        return $this->IBAN;
    }

    /**
     * @param mixed $mandateId
     */
    public function setMandateid($mandateId) {
        $this->Mandateid = $mandateId;
    }

    /**
     * @return mixed
     */
    public function getMandateid() {
        return $this->Mandateid;
    }

    /**
     * @param mixed $mdtseqtype
     */
    public function setMdtseqtype($mdtseqtype) {
        $this->Mdtseqtype = $mdtseqtype;
    }

    /**
     * @return mixed
     */
    public function getMdtseqtype() {
        return $this->Mdtseqtype;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference) {
        $this->Reference = $reference;
    }

    /**
     * @return string
     */
    public function getReference() {
        return $this->Reference;
    }

    /**
     * @param string $sdCity
     */
    public function setSdCity($sdCity) {
        $this->sdCity = $sdCity;
    }

    /**
     * @return string
     */
    public function getSdCity() {
        return $this->sdCity;
    }

    /**
     * @param string $sdCountryCode
     */
    public function setSdCountryCode($sdCountryCode) {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @return string
     */
    public function getSdCountryCode() {
        return $this->sdCountryCode;
    }

    /**
     * @param string $sdEmail
     */
    public function setSdEmail($sdEmail) {
        $this->sdEmail = $sdEmail;
    }

    /**
     * @return string
     */
    public function getSdEmail() {
        return $this->sdEmail;
    }

    /**
     * @param string $sdFirstName
     */
    public function setSdFirstName($sdFirstName) {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @return string
     */
    public function getSdFirstName() {
        return $this->sdFirstName;
    }

    /**
     * @param string $sdLastName
     */
    public function setSdLastName($sdLastName) {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @return string
     */
    public function getSdLastName() {
        return $this->sdLastName;
    }

    /**
     * @param string $sdStreet
     */
    public function setSdStreet($sdStreet) {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @return string
     */
    public function getSdStreet() {
        return $this->sdStreet;
    }

    /**
     * @param string $sdStreetNr
     */
    public function setSdStreetNr($sdStreetNr) {
        $this->sdStreetNr = $sdStreetNr;
    }

    /**
     * @return string
     */
    public function getSdStreetNr() {
        return $this->sdStreetNr;
    }

    /**
     * @param string $sdZip
     */
    public function setSdZip($sdZip) {
        $this->sdZip = $sdZip;
    }

    /**
     * @return string
     */
    public function getSdZip() {
        return $this->sdZip;
    }

    /**
     * @param string $tid
     */
    public function setTID($tid) {
        $this->TID = $tid;
    }

    /**
     * @return string
     */
    public function getTID() {
        return $this->TID;
    }

    /**
     * @param string $addrCity
     */
    public function setAddrCity($addrCity) {
        $this->AddrCity = $addrCity;
    }

    /**
     * @return string
     */
    public function getAddrCity() {
        return $this->AddrCity;
    }

    /**
     * @param string $addrCountryCode
     */
    public function setAddrCountryCode($addrCountryCode) {
        $this->AddrCountryCode = $addrCountryCode;
    }

    /**
     * @return string
     */
    public function getAddrCountryCode() {
        return $this->AddrCountryCode;
    }

    /**
     * @param string $addrState
     */
    public function setAddrState($addrState) {
        $this->AddrState = $addrState;
    }

    /**
     * @return string
     */
    public function getAddrState() {
        return $this->AddrState;
    }

    /**
     * @param string $addrStreet
     */
    public function setAddrStreet($addrStreet) {
        $this->AddrStreet = $addrStreet;
    }

    /**
     * @return string
     */
    public function getAddrStreet() {
        return $this->AddrStreet;
    }

    /**
     * @param string $addrStreet2
     */
    public function setAddrStreet2($addrStreet2) {
        $this->AddrStreet2 = $addrStreet2;
    }

    /**
     * @return string
     */
    public function getAddrStreet2() {
        return $this->AddrStreet2;
    }

    /**
     * @param string $addrZIP
     */
    public function setAddrZIP($addrZIP) {
        $this->AddrZIP = $addrZIP;
    }

    /**
     * @return string
     */
    public function getAddrZIP() {
        return $this->AddrZIP;
    }

    /**
     * @param string $billingAgreementiD
     */
    public function setBillingAgreementiD($billingAgreementiD) {
        $this->BillingAgreementiD = $billingAgreementiD;
    }

    /**
     * @return string
     */
    public function getBillingAgreementiD() {
        return $this->BillingAgreementiD;
    }

    /**
 * @param string $eMail
 */
    public function setEMail($eMail) {
        $this->EMail = $eMail;
    }

    /**
     * @return string
     */
    public function getEMail() {
        return $this->EMail;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->FirstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->FirstName;
    }

    /**
     * @param string $infoText
     */
    public function setInfoText($infoText) {
        $this->InfoText = $infoText;
    }

    /**
     * @return string
     */
    public function getInfoText() {
        return $this->InfoText;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->LastName = $lastName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->LastName;
    }

    /**
     * @param string $transactionID
     */
    public function setTransactionID($transactionID) {
        $this->TransactionID = $transactionID;
    }

    /**
     * @return string
     */
    public function getTransactionID() {
        return $this->TransactionID;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $accBank
     */
    public function setAccBank($accBank) {
        $this->AccBank = $accBank;
    }

    /**
     * @return string
     */
    public function getAccBank() {
        return $this->AccBank;
    }

    /**
     * @param string $accIban
     */
    public function setAccIBAN($accIban) {
        $this->AccIBAN = $accIban;
    }

    /**
     * @return string
     */
    public function getAccIBAN() {
        return $this->AccIBAN;
    }

    /**
     * @param string $accNr
     */
    public function setAccNr($accNr) {
        $this->AccNr = $accNr;
    }

    /**
     * @return string
     */
    public function getAccNr() {
        return $this->AccNr;
    }

    /**
     * @param string $paymentGuarantee
     */
    public function setPaymentGuarantee($paymentGuarantee) {
        $this->PaymentGuarantee = $paymentGuarantee;
    }

    /**
     * @return string
     */
    public function getPaymentGuarantee() {
        return $this->PaymentGuarantee;
    }

    /**
     * @param string $paymentPurpose
     */
    public function setPaymentPurpose($paymentPurpose) {
        $this->PaymentPurpose = $paymentPurpose;
    }

    /**
     * @return string
     */
    public function getPaymentPurpose() {
        return $this->PaymentPurpose;
    }

    /**
     * @param string $RNo
     */
    public function setRNo($RNo) {
        $this->RNo = $RNo;
    }

    /**
     * @return string
     */
    public function getRNo() {
        return $this->RNo;
    }

    /**
     * @param int $Age
     */
    public function setAge($Age) {
        $this->Age = $Age;
    }

    /**
     * @return int
     */
    public function getAge() {
        return $this->Age;
    }

    /**
     * @param \Fatchip\CTPayment\CTResponse\CTResponseIframe\datetime $Birthday
     */
    public function setBirthday($Birthday) {
        $this->Birthday = $Birthday;
    }

    /**
     * @return \Fatchip\CTPayment\CTResponse\CTResponseIframe\datetime
     */
    public function getBirthday() {
        return $this->Birthday;
    }

    /**
     * @param string $InvNo
     */
    public function setInvNo($InvNo) {
        $this->InvNo = $InvNo;
    }

    /**
     * @return string
     */
    public function getInvNo() {
        return $this->InvNo;
    }

    /**
     * @param int $SecCriteria
     */
    public function setSecCriteria($SecCriteria) {
        $this->SecCriteria = $SecCriteria;
    }

    /**
     * @return int
     */
    public function getSecCriteria() {
        return $this->SecCriteria;
    }

    /**
     * @param mixed $AddrStreetNr
     */
    public function setAddrStreetNr($AddrStreetNr) {
        $this->AddrStreetNr = $AddrStreetNr;
    }

    /**
     * @return mixed
     */
    public function getAddrStreetNr() {
        return $this->AddrStreetNr;
    }

    /**
     * @param string $result
     */
    public function setResult($result) {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * @param mixed $partialResults
     */
    public function setPartialResults($partialResults) {
        $this->partialResults = $partialResults;
    }

    /**
     * @return mixed
     */
    public function getPartialResults() {
        return $this->partialResults;
    }

    /**
     * @param mixed $AmountAuth
     */
    public function setAmountAuth($AmountAuth) {
        $this->AmountAuth = $AmountAuth;
    }

    /**
     * @return mixed
     */
    public function getAmountAuth() {
        return $this->AmountAuth;
    }

    /**
     * @param mixed $AmountCap
     */
    public function setAmountCap($AmountCap) {
        $this->AmountCap = $AmountCap;
    }

    /**
     * @return mixed
     */
    public function getAmountCap() {
        return $this->AmountCap;
    }

    /**
     * @param mixed $AmountCred
     */
    public function setAmountCred($AmountCred) {
        $this->AmountCred = $AmountCred;
    }

    /**
     * @return mixed
     */
    public function getAmountCred() {
        return $this->AmountCred;
    }
}

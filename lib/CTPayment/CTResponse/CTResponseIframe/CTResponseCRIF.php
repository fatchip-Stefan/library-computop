<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 04.12.17
 * Time: 11:11
 */

namespace Fatchip\CTPayment\CTResponse\CTResponseIframe;

use Fatchip\CTPayment\CTResponse\CTResponseIframe;

class CTResponseCRIF extends CTResponseIframe
{

    /**
     * Status: OK oder FAILED
     *
     * @var string
     */
    protected $status;

    /**
     *
     * Handlungsempfehlung (Ampel): GREEN, YELLOW, RED, NO RESULT
     *
     * @var string
     */
    protected $result;

    protected $partialResults;

    protected $AddrStreet;

    protected $AddrStreetNr;

    protected $AddrCity;

    protected $AddrZip;

    protected $AddrCountryCode;

    protected $FirstName;

    protected $LastName;


    public function __construct(array $params = array())
    {
        parent::__construct($params);
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
     * @param string $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param mixed $AddrCity
     */
    public function setAddrCity($AddrCity) {
        $this->AddrCity = $AddrCity;
    }

    /**
     * @return mixed
     */
    public function getAddrCity() {
        return $this->AddrCity;
    }

    /**
     * @param mixed $AddrCountryCode
     */
    public function setAddrCountryCode($AddrCountryCode) {
        $this->AddrCountryCode = $AddrCountryCode;
    }

    /**
     * @return mixed
     */
    public function getAddrCountryCode() {
        return $this->AddrCountryCode;
    }

    /**
     * @param mixed $AddrStreet
     */
    public function setAddrStreet($AddrStreet) {
        $this->AddrStreet = $AddrStreet;
    }

    /**
     * @return mixed
     */
    public function getAddrStreet() {
        return $this->AddrStreet;
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
     * @param mixed $AddrZip
     */
    public function setAddrZip($AddrZip) {
        $this->AddrZip = $AddrZip;
    }

    /**
     * @return mixed
     */
    public function getAddrZip() {
        return $this->AddrZip;
    }

    /**
     * @param mixed $FirstName
     */
    public function setFirstName($FirstName) {
        $this->FirstName = $FirstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->FirstName;
    }

    /**
     * @param mixed $LastName
     */
    public function setLastName($LastName) {
        $this->LastName = $LastName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->LastName;
    }



}

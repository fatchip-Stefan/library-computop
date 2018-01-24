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


}

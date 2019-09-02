<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The Computop Shopware Plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Computop Shopware Plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Computop Shopware Plugin. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.6, 7.0 , 7.1
 *
 * @category   Payment
 * @package    FatchipCTPayment
 * @subpackage CTPaymentMethodsIframe
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */
namespace Fatchip\CTPayment\CTPaymentMethodsIframe;

use Fatchip\CTPayment\CTPaymentMethodIframe;

/**
 * Class Ideal
 * @package Fatchip\CTPayment\CTPaymentMethodsIframe
 */
class Ideal extends CTPaymentMethodIframe
{

    /**
     * Nicht bei PPRO: BIC der ausgewählten Bank (siehe Abfrage der hinterlegten iDEAL-Banken)
     *
     *
     * @var string
     */
    protected $issuerID;

    protected $idealDirekt;

    /**
     * Ideal constructor
     * @param array $config
     * @param \Fatchip\CTPayment\CTOrder\CTOrder|null $order
     * @param null|string $urlSuccess
     * @param null|string $urlFailure
     * @param $urlNotify
     * @param $orderDesc
     * @param $userData
     */
    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);

        $this->setUrlSuccess($urlSuccess);
        $this->setUrlFailure($urlFailure);
        $this->setUrlNotify($urlNotify);
    }

    /**
     * @ignore <description>
     * @param boolean $idealDirekt
     */
    public function setIdealDirekt($idealDirekt)
    {
        $this->idealDirekt = $idealDirekt;
    }

    /**
     * @ignore <description>
     * @return boolean
     */
    public function getIdealDirekt()
    {
        return $this->idealDirekt;
    }



    /**
     * @ignore <description>
     * @param string $issuerID
     */
    public function setIssuerID($issuerID)
    {
        $this->issuerID = $issuerID;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getIssuerID()
    {
        return $this->issuerID;
    }

    /**
     * returns paymentURL
     * @return string
     */
    public function getCTPaymentURL()    {
        return 'https://www.computop-paygate.com/ideal.aspx';
    }

    /**
     * returns null for captureURL because iDeal cannot be captured
     * @return null|string
     */
    public function getCTCaptureURL()
    {
        return null;
    }

    /**
     * returns IssuerListURL
     * @return string
     */
    public function getIssuerListURL()
    {
        $queryarray = array();
        $queryarray[] = 'merchantID=' . $this->getMerchantID();

        $query = join("&", $queryarray);

        $Len = strlen($query);  // Length of the plain text string
        $data = $this->ctEncrypt($query, $Len, $this->getBlowfishPassword());

        return 'https://www.computop-paygate.com/idealIssuerList.aspx' .  '?merchantID=' . $this->getMerchantID() . '&Len=' . $Len . "&Data=" . $data;
    }

}

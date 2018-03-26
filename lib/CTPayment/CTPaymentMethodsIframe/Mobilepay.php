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
 * Class Mobilepay
 * @package Fatchip\CTPayment\CTPaymentMethodsIframe
 */
class Mobilepay extends CTPaymentMethodIframe
{
    const paymentClass = 'Mobilepay';

    /**
     * Der param MobielNr kann, sofern bekannt aus dem Kundenkonto vorbelegt werden.
     * Diese option sollte aber im Backend auf aktiv bzw inaktiv gestellt werden können.
     * @var bool
     */
    protected $sendMobileNumber = false;

    /**
     * Sprache, in der das Mobilepay-Formular angezeigt werden soll.
     * Mögliche Werte: da, no, fi
     *
     * @var string
     */
    protected $language;

    /**
     * //Telefonnummer des Mobilepay-Accounts im Format +4595000012.
     * Der Parameter <mobileNr> kann, sofern bekannt aus dem Kundenkonto vorbelegt wreden.
     * Diese Option sollte aber im Backend auf aktiv bzw. inaktiv gestellt werden können.
     *
     * @var string
     */
    protected $MobileNr;

    /**
     * Mobilepay constructor
     * @param $config
     * @param $order
     * @param $urlSuccess
     * @param $urlFailure
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
     * @param string $mobileNr
     */
    public function setMobileNr($mobileNr)
    {
        $this->MobileNr = $mobileNr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getMobileNr()
    {
        return $this->MobileNr;
    }

    /**
     * @ignore <description>
     * @param boolean $sendMobileNumber
     */
    public function setSendMobileNumber($sendMobileNumber)
    {
        $this->sendMobileNumber = $sendMobileNumber;
    }

    /**
     * @ignore <description>
     * @return boolean
     */
    public function getSendMobileNumber()
    {
        return $this->sendMobileNumber;
    }

    /**
     * @ignore <description>
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Returns TransactionArray. Overridden because vor Mobilepay we have to add Language
     * and depending on pluginsettings the MobileNumber
     * @return array
     */
    protected function getTransactionArray()
    {
        //first get obligitory from parent
        $queryarray =  parent::getTransactionArray();
        //Optional for mobilepay
        if (strlen($this->getLanguage()) > 0) {
            $queryarray[] = "Language=" . $this->getLanguage();
        }
        if ($this->getSendMobileNumber() && strlen($this->getMobileNr()) > 0) {
            $queryarray[] = "mobileNr=" . $this->getMobileNr();
        }
        return $queryarray;
    }

    /**
     * returns the PaymentURL
     * @return string
     */
    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/MobilePayDB.aspx';
    }

}

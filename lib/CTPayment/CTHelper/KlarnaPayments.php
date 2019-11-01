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
 * @subpackage CTPaymentMethods
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */

namespace Fatchip\CTPayment\CTHelper;

use Fatchip\CTPayment\CTOrder\CTOrder;
use Shopware\Plugins\FatchipCTPayment\Util;


/**
 * @package Fatchip\CTPayment\CTPaymentMethods
 */
class KlarnaPayments
{
    /**
     * @return \Fatchip\CTPayment\CTPaymentMethods\KlarnaPayments
     */
    public function createCTKlarnaPayment()
    {
        $userData = Shopware()->Modules()->Admin()->sGetUserData();
        $paymentName = $userData['additional']['payment']['name'];

        $payTypes = [
            'pay_now' => 'pay_now',
            'pay_later' => 'pay_later',
            'slice_it' => 'pay_over_time'
        ];

        // set payType to correct value
        foreach ($payTypes as $key => $value) {
            $length = strlen($key);
            if (substr($paymentName, -$length) === $key) {
                $payType = $value;
                break;
            }
        }

        if (!isset($payType)) {
            return null;
        }

        //TODO: from this helper
        $articleList = \Fatchip\CTPayment\CTPaymentMethods\KlarnaPayments::createArticleListBase64();
        $taxAmount = \Fatchip\CTPayment\CTPaymentMethods\KlarnaPayments::calculateTaxAmount($articleList);

        $URLConfirm = Shopware()->Front()->Router()->assemble([
            'controller' => 'checkout',
            'action' => 'finish',
            'forceSecure' => true,
        ]);

        $ctOrder = $this->createCTOrder();

        if (!$ctOrder instanceof CTOrder) {
            return null;
        }

        $klarnaAccount = $this->pluginConfig['klarnaaccount'];

        /** @var KlarnaPayments $payment */
        $payment = $this->container->get('FatchipCTPaymentApiClient')->getPaymentClass('KlarnaPayments', $this->pluginConfig);
        $payment->storeKlarnaSessionRequestParams(
            $taxAmount,
            $articleList,
            $URLConfirm,
            $payType,
            $klarnaAccount,
            $userData['additional']['country']['countryiso'],
            $ctOrder->getAmount(),
            $ctOrder->getCurrency(),
            \Fatchip\CTPayment\CTPaymentMethods\KlarnaPayments::generateTransID(),
            $_SERVER['REMOTE_ADDR']
        );

        return $payment;
    }

    public function cleanSessionVars()
    {
        $session = Shopware()->Session();
        $sessionVars = [
            'FatchipCTKlarnaPaymentSessionResponsePayID',
            'FatchipCTKlarnaPaymentSessionResponseTransID',
            'FatchipCTKlarnaPaymentTokenExt',
            'FatchipCTKlarnaPaymentArticleListBase64',
            'FatchipCTKlarnaPaymentAmount',
            'FatchipCTKlarnaPaymentAddressHash',
            'FatchipCTKlarnaPaymentHash',
            'FatchipCTKlarnaAccessToken',
            'FatchipCTKlarnaPaymentDispatchID',
            'CTError',
        ];

        foreach ($sessionVars as $sessionVar) {
            $session->offsetUnset($sessionVar);
        }
    }
}

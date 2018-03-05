<?php
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
 * PHP version 5.6, 7 , 7.1
 *
 * @category  Payment
 * @package   Computop_Shopware5_Plugin
 * @author    FATCHIP GmbH <support@fatchip.de>
 * @copyright 2018 Computop
 * @license   <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link      https://www.computop.com
 */

namespace Fatchip\CTPayment;

/**
 * Class CTPaymentMethods
 * @package Fatchip\CTPayment
 */
class CTPaymentMethods
{
    const paymentMethods =
        [
            [
                'name' => 'fatchip_computop_creditcard',
                'shortname' => 'Kreditkarte',
                'description' => 'Computop Kreditkarte',
                'action' => 'FatchipCTCreditCard',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'CreditCard',
            ],
            [
                'name' => 'fatchip_computop_easycredit',
                'shortname' => 'Easycredit',
                'description' => 'Computop Easycredit',
                'action' => 'FatchipCTEasyCredit',
                'template' => 'fatchip_computop_easycredit.tpl',
                'additionalDescription' => 'Rechnungs- und Lieferadresse müssen gleich sein, damit easyCredit genutzt werden kann',
                'className' => 'EasyCredit',
            ],
            [
                'name' => 'fatchip_computop_ideal',
                'shortname' => 'iDEAL',
                'description' => 'Computop iDEAL',
                'action' => 'FatchipCTIdeal',
                'template' => 'fatchip_computop_ideal.tpl',
                'additionalDescription' => '',
                'className' => 'Ideal',
                'countries' => ['NL'],
            ],
            [
                'name' => 'fatchip_computop_klarna_invoice',
                'shortname' => 'Klarna Rechnungskauf',
                'description' => 'Computop Klarna Rechnungskauf',
                'action' => 'FatchipCTKlarna',
                'template' => 'fatchip_computop_klarna_invoice.tpl',
                'additionalDescription' => '',
                'className' => 'Klarna',
                'countries' => ['DE', 'NL', 'DK', 'FI', 'SE', 'NO'],
            ],
            [
                'name' => 'fatchip_computop_klarna_installment',
                'shortname' => 'Klarna Ratenkauf',
                'description' => 'Computop Klarna Ratenkauf',
                'action' => 'FatchipCTKlarna',
                'template' => 'fatchip_computop_klarna_installment.tpl',
                'additionalDescription' => '',
                'className' => 'Klarna',
                'countries' => ['NL'],
            ],
            [
                'name' => 'fatchip_computop_lastschrift',
                'shortname' => 'Lastschrift',
                'description' => 'Computop Lastschrift',
                'action' => 'FatchipCTLastschrift',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Lastschrift',
            ],
            [
                'name' => 'fatchip_computop_mobilepay',
                'shortname' => 'Mobile Pay',
                'description' => 'Computop Mobile Pay',
                'action' => 'FatchipCTMobilepay',
                'countries' => ['DK', 'NO', 'FI', 'SE'],
                'template' => '',
                'additionalDescription' => '',
                'className' => 'MobilePay',
            ],
            [
                'name' => 'fatchip_computop_paydirekt',
                'shortname' => 'Paydirekt',
                'description' => 'Computop Paydirekt',
                'action' => 'FatchipCTPaydirekt',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Paydirekt',
            ],
            [
                'name' => 'fatchip_computop_paypal_standard',
                'shortname' => 'PayPal',
                'description' => 'Computop PayPal Standard',
                'action' => 'FatchipCTPaypalStandard',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'PaypalStandard',
            ],
            [
                'name' => 'fatchip_computop_paypal_express',
                'shortname' => 'PayPalExpress',
                'description' => 'Computop PayPal Express',
                'action' => 'FatchipCTPaypalExpress',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'PaypalExpress',
            ],
            [
                'name' => 'fatchip_computop_postfinance',
                'shortname' => 'Postfinance',
                'description' => 'Computop Postfinance',
                'action' => 'FatchipCTPostFinance',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'PostFinance',
            ],
            [
                'name' => 'fatchip_computop_przelewy24',
                'shortname' => 'Przelewy24',
                'description' => 'Computop Przelewy24',
                'action' => 'FatchipCTPrzelewy24',
                'countries' => ['PL',],
                'template' => '',
                'additionalDescription' => '',
                'className' => 'Przelewy24',
            ],
            [
                'name' => 'fatchip_computop_sofort',
                'shortname' => 'SOFORT',
                'description' => 'Computop SOFORT',
                'action' => 'FatchipCTSofort',
                'template' => 'fatchip_computop_sofort.tpl',
                'additionalDescription' => '',
                'className' => 'Sofort',
            ],
            [
                'name' => 'fatchip_computop_amazonpay',
                'shortname' => 'AmazonPay',
                'description' => 'Computop AmazonPay',
                'action' => 'FatchipCTAmazon',
                'template' => '',
                'additionalDescription' => '',
                'className' => 'AmazonPay',
            ],
        ];
}

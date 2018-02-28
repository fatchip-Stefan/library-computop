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

class CTPaymentConfigForms
{
    const formGeneralTextElements =
        [
            'merchantID' => [
                'name' => 'merchantID',
                'type' => 'text',
                'value' => '',
                'label' => 'MerchantID',
                'required' => true,
                'description' => '',
            ],
            'mac' => [
                'name' => 'mac',
                'type' => 'text',
                'value' => '',
                'label' => 'MAC',
                'required' => true,
                'description' => '',
            ],
            'blowfishPassword' => [
                'name' => 'blowfishPassword',
                'type' => 'text',
                'value' => '',
                'label' => 'Blowfish Password',
                'required' => true,
                'description' => '',
            ],
        ];

    const formGeneralSelectElements =
        [
            'debuglog' => [
                'name' => 'debuglog',
                'type' => 'select',
                'value' => 'inactive',
                'label' => 'Debug Protokoll',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['inactive', 'keine Protokollierung'],
                        ['active', 'Protokollierung'],
                    ],
                'description' => '',
            ],
        ];

    const formCreditCardSelectElements =
        [
            'creditCardCaption' => [
                'name' => 'creditCardCaption',
                'type' => 'select',
                'value' => 'AUTO',
                'label' => 'Kreditkarte - Capture Modus',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['AUTO', 'Automatisch'],
                        ['MANUAL', 'Manuell'],
                        ['DELAYED', 'Verzögert'],
                    ],
                'description' => '',
            ],
            'creditCardAcquirer' => [
                'name' => 'creditCardAcquirer',
                'type' => 'select',
                'value' => 'GICC',
                'label' => 'Kreditkarte - Acquirer',
                'required' => 'true',
                'editable' => false,
                'store' =>
                    [
                        ['GICC', 'GICC: Concardis, B+S Card Service, EVO Payments, American Express, Elavon, SIX Payment Service'],
                        ['CAPN', 'CAPN: American Express'],
                        ['Omnipay', 'Omnipay: EMS payment solutions, Global Payments, Paysquare'],
                    ],
                'description' => '',
            ],
        ];

    const formCreditCardNumberElements =
        [
            'creditCardDelay' => [
                'name' => 'creditCardDelay',
                'type' => 'number',
                'value' => '1',
                'label' => 'Kreditkarte - Verzögerung Einzug',
                'required' => true,
                'description' => 'Verzögerung in Stunden wenn als Capture Modus "Verzögert" gewählt wurde',
            ],
        ];

    const formIdealSelectElements =
        [
            'idealDirektOderUeberSofort' => [
                'name' => 'idealDirektOderUeberSofort',
                'type' => 'select',
                'value' => 'DIREKT',
                'label' => 'iDEAL - iDEAL Direkt oder über Sofort',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['DIREKT', 'iDEAL Direkt'],
                        ['SOFORT', 'via Sofort'],
                    ],
                'description' => '',
            ],
        ];


    const formLastschriftSelectElements =
      [
        'lastschriftDienst' => [
          'name' => 'lastschriftDienst',
          'type' => 'select',
          'value' => 'DIREKT',
          'label' => 'Lastschrift - Anbinden über Dienst',
          'required' => true,
          'editable' => false,
          'store' =>
            [
              ['DIREKT', 'Direktanbindung'],
              ['EVO', 'EVO Payments'],
              ['INTERCARD', 'Intercard'],
            ],
          'description' => '',
        ],
        'lastschriftCaption' => [
          'name' => 'lastschriftCaption',
          'type' => 'select',
          'value' => 'AUTO',
          'label' => 'Lastschrift - Capture Modus',
          'required' => true,
          'editable' => false,
          'store' =>
            [
              ['AUTO', 'Automatisch'],
              ['MANUAL', 'Manuell'],
              ['DELAYED', 'Verzögert'],
            ],
          'description' => '',
        ],
      ];

    const formLastschriftNumberElements =
      [
        'lastschriftDelay' => [
          'name' => 'lastschriftDelay',
          'type' => 'number',
          'value' => '1',
          'label' => 'Lastschrift - Verzögerung Einzug',
          'required' => true,
          'description' => 'Verzögerung in Stunden wenn als Capture Modus "Verzögert" gewählt wurde',
        ],
      ];

    const formPayDirektTextElements =
        [
            'payDirektShopApiKey' => [
                'name' => 'payDirektShopApiKey',
                'type' => 'text',
                'value' => '',
                'label' => 'Paydirekt - Shop Api Key',
                'required' => true,
                'description' => '',
            ],
        ];

    const formPayDirektSelectElements =
        [
            'payDirektCaption' => [
                'name' => 'payDirektCaption',
                'type' => 'select',
                'value' => 'AUTO',
                'label' => 'Paydirekt - Capture Modus',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['AUTO', 'Automatisch'],
                        ['MANUAL', 'Manuell'],
                        ['DELAYED', 'Verzögert'],
                    ],
                'description' => '',
            ],
        ];

    const formPayDirektNumberElements =
        [
            'payDirektCardDelay' => [
                'name' => 'payDirektCardDelay',
                'type' => 'number',
                'value' => '1',
                'label' => 'Paydirekt - Verzögerung Einzug',
                'required' => true,
                'description' => 'Verzögerung in Stunden wenn als Capture Modus "Verzögert" gewählt wurde',
            ],
        ];

    const formPayPalSelectElements =
        [
            'paypalCaption' => [
                'name' => 'paypalCaption',
                'type' => 'select',
                'value' => 'AUTO',
                'label' => 'Paypal - Capture Modus',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['AUTO', 'Automatisch'],
                        ['MANUAL', 'Manuell'],
                    ],
                'description' => 'bestimmt, ob der angefragte Betrag sofort oder erst später abgebucht wird. <br>
                                  <b>Wichtig:<br>Bitte kontaktieren Sie den Computop Support für Manual, um die unterschiedlichen Einsatzmöglichkeiten abzuklären.</b>',
            ],
        ];

    const formAmazonTextElements =
        [
            'amazonSellerId' => [
                'name' => 'amazonSellerId',
                'type' => 'text',
                'value' => '',
                'label' => 'AmazonPay - SellerId',
                'required' => true,
                'description' => 'Ihre SellerId',
            ],
            'amazonClientId' => [
                'name' => 'amazonClientId',
                'type' => 'text',
                'value' => '',
                'label' => 'AmazonPay - ClientId',
                'required' => true,
                'description' => 'Ihre ClientId',
            ],

        ];

    const formAmazonSelectElements =
        [
            'amazonButtonType' => [
                'name' => 'amazonButtonType',
                'type' => 'select',
                'value' => 'PwA',
                'label' => 'AmazonPay - Button Typ',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['PwA', 'Amazon Pay (Default)'],
                        ['Pay', 'Pay'],
                        ['A', 'A'],
                        ['LwA', 'LwA'],
                        ['Login', 'Login'],

                    ],
                'description' => 'Typ des AmazonPay Buttons',
            ],
            'amazonButtonColor' => [
                'name' => 'amazonButtonColor',
                'type' => 'select',
                'value' => 'Gold',
                'label' => 'AmazonPay - Button Farbe',
                'required' => 'true',
                'editable' => false,
                'store' =>
                    [
                        ['Gold', 'Gold'],
                        ['LightGray', 'LightGray'],
                        ['DarkGray', 'DarkGray'],
                    ],
                'description' => '',
            ],
            'amazonButtonSize' => [
                'name' => 'amazonButtonSize',
                'type' => 'select',
                'value' => 'small',
                'label' => 'AmazonPay - Button Größe',
                'required' => 'true',
                'editable' => false,
                'store' =>
                    [
                        ['small', 'small'],
                        ['medium', 'medium'],
                    ],
                'description' => '',
            ],
        ];

    const formBonitaetElements =
        [
            'bonitaetusereturnaddress' => [
                'name' => 'bonitaetusereturnaddress',
                'type' => 'boolean',
                'value' => false,
                'label' => 'Bonitätsprüfung - Zurückgelieferte Adressdaten verwenden',
                'required' => true,
                'description' => '',
            ],
            'bonitaetinvalidateafterdays' => [
                'name' => 'bonitaetinvalidateafterdays',
                'type' => 'number',
                'value' => '30',
                'label' => 'Bonitätsprüfung - Wiederholen nach wieviele Tage',
                'required' => true,
                'description' => 'Verzögerung in Stunden wenn als Capture Modus "Verzögert" gewählt wurde',
            ],
        ];

    const formBonitaetSelectElements =
        [
            'crifmethod' => [
                'name' => 'crifmethod',
                'type' => 'select',
                'value' => 'inactive',
                'label' => 'CRIF Bonitätsprüfung',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['inactive', 'Inaktiv'],
                        ['QuickCheck', 'QuickCheck'],
                        ['CreditCheck', 'CreditCheck'],
                    ],
                'description' => '',
            ],
        ];

}

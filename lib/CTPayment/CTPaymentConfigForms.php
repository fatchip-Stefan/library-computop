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
                'description' => 'Ihre Merchant Id (Benutzername)',
            ],
            'mac' => [
                'name' => 'mac',
                'type' => 'text',
                'value' => '',
                'label' => 'MAC',
                'required' => true,
                'description' => 'Ihr HMAC-Key',
            ],
            'blowfishPassword' => [
                'name' => 'blowfishPassword',
                'type' => 'text',
                'value' => '',
                'label' => 'Blowfish Password',
                'required' => true,
                'description' => 'Ihr Verschlüsselungs-Passwort',
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
                'description' => 'Erzeugt eine Log Datei <FatchipCTPayment_.log> mit Debug Ausgaben im Shopware Protokollverzeichnis.<BR>',
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
                'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                                  <b>MANUAL</b>: Geldeinzüge werden von Ihnen selbst über Computop Analytics durchgeführt.<BR>
                                  <b>VERZÖGERT</b>: Wie AUTO, aber mit einer Verzügerung in Stunden',
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
                        ['GICC', ''],
                        ['CAPN', ''],
                        ['Omnipay', ''],
                    ],
                'description' => '<b>GICC</b>: Concardis, B+S Card Service, EVO Payments, American Express, Elavon, SIX Payment Service<BR>
                                  <b>CAPN</b>: American Express<BR>
                                  <b>Omnipay</b>: EMS payment solutions, Global Payments, Paysquare',
            ],
        ];

    const formCreditCardNumberElements =
        [
            'creditCardDelay' => [
                'name' => 'creditCardDelay',
                'type' => 'number',
                'value' => '1',
                'label' => 'Kreditkarte - Verzögerung Capture',
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
                'label' => 'iDEAL - Dienst',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['DIREKT', 'iDEAL Direkt'],
                        ['SOFORT', 'via Sofort'],
                    ],
                'description' => 'Ideal Zahlungen können direkt über Ideal oder über Sofort abgewickelt werden',
            ],
        ];


    const formLastschriftSelectElements =
      [
        'lastschriftDienst' => [
          'name' => 'lastschriftDienst',
          'type' => 'select',
          'value' => 'DIREKT',
          'label' => 'Lastschrift - Dienst',
          'required' => true,
          'editable' => false,
          'store' =>
            [
              ['DIREKT', 'Direktanbindung'],
              ['EVO', 'EVO Payments'],
              ['INTERCARD', 'Intercard'],
            ],
          'description' => 'Lastschrift Zahlungen können direkt, über EVO oder über INTERCARD abgewickelt werden.',
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
          'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                            <b>MANUAL</b>: Geldeinzüge werden von Ihnen selbst über Computop Analytics durchgeführt.<BR>
                            <b>VERZÖGERT</b>: Wie AUTO, aber mit einer Verzügerung in Stunden',
        ],
      ];

    const formLastschriftNumberElements =
      [
        'lastschriftDelay' => [
          'name' => 'lastschriftDelay',
          'type' => 'number',
          'value' => '1',
          'label' => 'Lastschrift - Verzögerung Capture',
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
                'description' => 'Ihr Paydirekt Api Schlüssel',
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
                'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                                  <b>MANUAL</b>: Geldeinzüge werden von Ihnen selbst über das Shopware Bestellungs- Backend durchgeführt.<BR>
                                  <b>VERZÖGERT</b>: Wie AUTO, aber mit einer Verzögerung in Stunden',
            ],
        ];

    const formPayDirektNumberElements =
        [
            'payDirektCardDelay' => [
                'name' => 'payDirektCardDelay',
                'type' => 'number',
                'value' => '1',
                'label' => 'Paydirekt - Verzögerung Capture',
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
                'description' => 'bestimmt, ob der angefragte Betrag sofort oder erst später eingezogen wird. <br>
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
                'description' => 'Ihre Amazonpay SellerId',
            ],
            'amazonClientId' => [
                'name' => 'amazonClientId',
                'type' => 'text',
                'value' => '',
                'label' => 'AmazonPay - ClientId',
                'required' => true,
                'description' => 'Ihre Amazonpay ClientId',
            ],

        ];

    const formAmazonSelectElements =
        [
            'amazonButtonType' => [
                'name' => 'amazonButtonType',
                'type' => 'select',
                'value' => 'PwA',
                'label' => '<a href="https://pay.amazon.com/de/developer/documentation/lpwa/201952050#ENTER_TYPE_PARAMETER" target="_blank">AmazonPay - Button Typ</a>',
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
                'description' => 'Typ des Amazon Buttons<BR>
                                  Das Aussehen der verschiedenen Buttons.<BR>
                                  Klicken Sie links auf den Link "AmazonPay - Button Typ"',
            ],
            'amazonButtonColor' => [
                'name' => 'amazonButtonColor',
                'type' => 'select',
                'value' => 'Gold',
                'label' => '<a href="https://pay.amazon.com/de/developer/documentation/lpwa/201952050#ENTER_COLOR_PARAMETER" target="_blank">AmazonPay - Button Farbe</a>',
                'required' => 'true',
                'editable' => false,
                'store' =>
                    [
                        ['Gold', 'Gold'],
                        ['LightGray', 'LightGray'],
                        ['DarkGray', 'DarkGray'],
                    ],
                'description' => 'Farbe des Amazon Buttons<BR>
                                  Das Aussehen der verschiedenen Buttons.<BR>
                                  Klicken Sie links auf den Link "AmazonPay - Button Farbe"',
            ],
            'amazonButtonSize' => [
                'name' => 'amazonButtonSize',
                'type' => 'select',
                'value' => 'small',
                'label' => '<a href="https://pay.amazon.com/de/developer/documentation/lpwa/201952050#ENTER_SIZE_PARAMETER" target="_blank">AmazonPay - Button Größe</a>',
                'required' => 'true',
                'editable' => false,
                'store' =>
                    [
                        ['small', 'small'],
                        ['medium', 'medium'],
                    ],
                'description' => 'Größe des Amazon Buttons<BR>
                                  Das Aussehen der verschiedenen Buttons.<BR>
                                  Klicken Sie links auf den Link "AmazonPay - Button Größe"',
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
                'description' => 'Ersetzt die Rechnungsaddresse mit u.U. korrigierten Adressen aus der Bonitätsprüfung',
            ],
            'bonitaetinvalidateafterdays' => [
                'name' => 'bonitaetinvalidateafterdays',
                'type' => 'number',
                'value' => '30',
                'label' => 'Bonitätsprüfung - Gültigkeit der Bonitätsprüfung in Tagen',
                'required' => true,
                'description' => 'Stellen Sie hier ein, wie lange ein bereits durchgeführte Bontitätsprüfung gültig bleibt',
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
                'description' => 'führt eine Bonitätsprüfung aus, bevor ein Benutzer Zahlarten auswählen kann.<BR>
                                  Erstellen Sie unter "Einstellungen->Riskmanagement" Regeln mit den Bedingungen<BR>
                                  "Computop Risikoampel IST <Farbe>"<BR>und<BR>
                                  "Computop Risikoampel IST NICHT <Farbe>"<BR>',
            ],
        ];

}

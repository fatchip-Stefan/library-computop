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
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */

namespace Fatchip\CTPayment;
/**
 * Class CTPaymentConfigForms
 * @package Fatchip\CTPayment
 */
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
            'prefixOrdernumber' => [
                'name' => 'prefixOrdernumber',
                'type' => 'text',
                'value' => '',
                'label' => 'Bestellnummer Präfix',
                'required' => true,
                'description' => 'Präfix für Bestellnummern. Sie können folgende Platzhalter verwenden: %transid% , %payid%, %xid%',
            ],
            'suffixOrdernumber' => [
                'name' => 'suffixOrdernumber',
                'type' => 'text',
                'value' => '',
                'label' => 'Bestellnummer Suffix',
                'required' => true,
                'description' => 'Suffix für Bestellnummern. Sie können folgende Platzhalter verwenden: %transid% , %payid%, %xid%',
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
            'creditCardMode' => [
                'name' => 'creditCardMode',
                'type' => 'select',
                'value' => 'IFrame',
                'label' => 'Kreditkarte - Modus',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['IFRAME', 'IFrame'],
                        ['SILENT', 'Silent Mode'],
                    ],
                'description' => '<b>IFrame</b>: Kreditkartendaten werden nach klick auf "Zahlungsplichtig bestellen" in ein IFrame eingegeben<BR>
                                  <b>Silent Mode</b>: Kreditkartendaten werden auf der Seite "Zahlungsart wählen" eingegeben.<BR>'
            ],
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
                    ],
                'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                                  <b>MANUAL</b>: Geldeinzüge werden von Ihnen manuell im Shopbackend durchgeführt.',
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
                        ['GICC', 'GICC'],
                        ['CAPN', 'CAPN'],
                        ['Omnipay', 'Omnipay'],
                    ],
                'description' => '<b>GICC</b>: Concardis, B+S Card Service, EVO Payments, American Express, Elavon, SIX Payment Service<BR>
                                  <b>CAPN</b>: American Express<BR>
                                  <b>Omnipay</b>: EMS payment solutions, Global Payments, Paysquare',
            ],
        ];

    const formCreditCardNumberElements =
        [
        ];

    const formCreditCardTextElements =
        [
            'creditCardTemplate' => [
                'name' => 'creditCardTemplate',
                'type' => 'text',
                'value' => '',
                'label' => 'Kreditkarte - Template Name',
                'required' => false,
                'description' => 'Name der XSLT-Datei mit Ihrem individuellen Layout für das Bezahlformular. Wenn Sie das neugestaltete und abwärtskompatible Computop-Template nutzen möchten, übergeben Sie den Templatenamen „ct_compatible“. Wenn Sie das Responsive Computop-Template für mobile Endgeräte nutzen möchten, übergeben Sie den Templatenamen „ct_responsive“.',
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
                    ],
                'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                            <b>MANUAL</b>: Geldeinzüge werden von Ihnen manuell im Shopbackend durchgeführt.',
            ],
            'lastschriftAnon' => [
                'name' => 'lastschriftAnon',
                'type' => 'select',
                'value' => 'Aus',
                'label' => 'Iban anonymisieren',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['Aus', 'Aus'],
                        ['An', 'An'],
                    ],
                'description' => 'Stellt im Checkout und im Mein Konto Bereich die Iban anonymisiert dar',
            ],
        ];

    const formLastschriftNumberElements =
        [
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
                    ],
                'description' => '<b>AUTO</b>: Reservierte Beträge werden sofort automatisch eingezogen.<BR>
                                  <b>MANUAL</b>: Geldeinzüge werden von Ihnen manuell im Shopbackend durchgeführt.',
            ],
        ];

    const formPayDirektNumberElements =
        [
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
            'amazonLiveMode' => [
                'name' => 'amazonLiveMode',
                'type' => 'select',
                'value' => 'Test',
                'label' => 'Amazon Modus',
                'required' => true,
                'editable' => false,
                'store' =>
                    [
                        ['Live', 'Live'],
                        ['Test', 'Test'],
                    ],
                'description' => 'AmazonPay im Live oder Testmodus benutzen',
            ],
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

    const formKlarnaTextElements =
      [
        'klarnaaction' => [
          'name' => 'klarnaaction',
          'type' => 'text',
          'value' => '',
          'label' => 'Klarna Aktionscode',
          'required' => true,
          'description' => 'Der Wert ist von Laufzeiten und Monatsraten abhängig, die Sie mit Klarna vereinbart haben. Dieser Wert kann per Subshop unterschiedlich sein.',
        ],
      ];

}

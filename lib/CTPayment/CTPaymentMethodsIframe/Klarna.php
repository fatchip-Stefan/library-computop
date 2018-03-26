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

use Fatchip\CTPayment;

/**
 * Class Klarna
 * @package Fatchip\CTPayment\CTPaymentMethodsIframe
 */
class Klarna extends CTPayment\CTPaymentMethodIframe
{
    const paymentClass = 'Klarna';

    /**
     * Für Privatpersonen optional, für Unternehmen Pflicht, z.B. Kontaktperson für den Kauf.
     * Über diesen Parameter können Mitteilungen und wichtige Informationen an den Kunden
     * auf der Rechnung mitgegeben werden.
     *
     * @var string
     */
    protected $Reference;

    /**
     * Telefonnummer des Käufers. Pflicht, wenn der Parameter mobileNr nicht mitge-geben wird
     *
     * @var string
     */
    protected $Phone;

    // Billing address fields

    /**
     * Bei Privatperson Pflicht: Vorname des Kunden Unternehmen: Darf nicht übergeben werden!
     *
     * @var string
     */
    protected $bdFirstName;

    /**
     * Bei Privatperson Pflicht: Nachname Unternehmen: Name des Unternehmens
     *
     * @var string
     */
    protected $bdLastName;

    /**
     * Straßenname in der Rechnungsadresse
     *
     * @var string
     */
    protected $bdStreet;

    /**
     * Hausnummer in der Rechnungsadresse. Optional, wenn der Parameter bdCountryCode den Wert DEU oder NLD hat.
     * Andernfalls können die Straße und Hausnummer zusammen im Parameter bdStreet übergeben werden.
     *
     * @var string
     */
    protected $bdStreetNr;

    /**
     * Postleitzahl in der Rechnungsadresse
     *
     * @var string
     */
    protected $bdZip;


    /**
     * Stadt in der Rechnungsadresse
     *
     * @var string
     *
     */
    protected $bdCity;

    /**
     * Ländercode der Rechnungsadresse dreistellig gemäß ISO-3166-1.
     * Erlaubt sind derzeit Deutschland, Österreich, Niederlande, Dänemark, Schweden, Norwegen und Finnland.
     *
     * @var string
     */
    protected $bdCountryCode;

    // Shipping address fields

    /**
     * Bei Privatperson Pflicht: Vorname des Kunden Unternehmen: Darf nicht übergeben werden!
     *
     * @var string
     */
    protected $sdFirstName;

    /**
     * Bei Privatperson Pflicht: Nachname Unternehmen: Name des Unternehmens
     *
     * @var string
     */
    protected $sdLastName;

    /**
     * Strasse in der Lieferadresse
     * @var string
     */
    protected $sdStreet; //

    /**
     * Hausnummer in der Lieferadresse. Optional, wenn der Parameter sdCount-ryCode den Wert DEU oder NLD hat.
     * Andernfalls können die Straße und Haus-nummer zusammen im Parameter sdStreet übergeben werden.
     *
     * @var string
     */
    protected $sdStreetNr;

    /**
     * Ort in der Lieferadresse
     *
     * @var string
     */
    protected $sdCity;

    /**
     * Ländercode der Lieferadresse dreistellig gemäß ISO-3166-1.
     * rlaubt sind der-zeit Deutschland, Österreich, Niederlande, Dänemark, Schweden, Norwegen und Finnland.
     *
     * @var string
     */
    protected $sdCountryCode;

    /**
     * E-Mail-Adresse des Kunden
     *
     * @var string
     */
    protected $Email;

    /**
     * Mobiltelefonnummer des Kunden. Pflicht, wenn der Parameter phone nicht mit-gegeben wird
     *
     * @var string
     */
    protected $MobileNr;

    /**
     * Privatpersonen: Geburtsdatum im Format JJJJ-MM-TT Optional, wenn socialSecurityNumber vollständig übergeben wird.
     * Unternehmen: Darf nicht übergeben werden!
     *
     * @var string
     */
    protected $DateOfBirth;

    /**
     * Privatpersonen: Geschlecht <f> für weiblich, <m> für männlich.
     * Pflichtparame-ter, wenn der bdCountryCode den Wert DEU, AUT oder NLD hat.
     * Optional, wenn socialSecurityNumber vollständig übergeben wird. Unternehmen: Darf nicht übergeben werden!
     *
     * @var string
     */
    protected $Gender;

    /**
     * Privatpersonen: Teil der Sozialversicherungsnummer.
     * Nicht in DE, AT und NL. Pflichtfeld in SE, FI, DK mit 4stelligem Wert (NNNN).
     * Pflichtfeld in NO mit 5stelli-gem Wert (NNNNN). Kann auch vollständig 10- oder 11stellig in folgenden Formaten
     * übergeben werden. In diesem Fall müssen die Parameter dateOfBirth und gender nicht mehr mit übergeben werden.
     * SE: YYMMDD-NNNN FI: DDMMYY-NNNN DK: DDMMYYNNNN NO: DDMMYYNNNNN Unternehmen: Handelsregisternummer
     *
     * @var string
     */
    protected $SocialSecurityNumber;

    /**
     * Jahresgehalt. Nur in DK Pflicht (Betrag in Öre), sonst optional
     *
     * @var int
     */
    protected $AnnualSalary;


    /**
     * <F> für Firmen, <P> für Personen
     *
     * @var string
     */
    protected $CompanyOrPerson;

    /**
     * Aktionscode legt Rechnungs- oder Finanzierungskauf fest.
     * <-1> ist Rechnungskauf.
     * Werte für Finanzkauf  von Laufzeiten und Monatsraten abhängig, die zwischen Klarna und Händler vereinbart wurden.
     *
     * @var int
     */
    protected $KlarnaAction;

    /**
     * Kennzeichnung der Rechnung:
     * <0> keine Kennung (Standard),
     * <2> Testrechnung,
     * <4> Postversand,
     * <8> Versand per E-Mail,
     * <16> Teilaktivierung der Rechnung,
     * <512> telefonische Transaktion,
     * <1024> PIN-Versand an Kunden
     *
     * @var string
     */
    protected $InvoiceFlag = '0';


    /**
     * Klarna constructor
     *
     * @param array $config
     * @param CTPayment\CTOrder\CTOrder|null $order
     * @param null|string $urlSuccess
     * @param null|string $urlFailure
     * @param $urlNotify
     * @param $orderDesc
     * @param $userData
     * @param $eventToken
     * @param $isFirm
     * @param $klarnaAction
     */
    public function __construct(
        $config,
        $order,
        $urlSuccess,
        $urlFailure,
        $urlNotify,
        $orderDesc,
        $userData,
        $eventToken,
        $isFirm,
        $klarnaAction
    ) {
        parent::__construct($config, $order, $orderDesc, $userData);
        $this->setUrlNotify($urlNotify);
        $this->setShippingAddress($order->getShippingAddress());
        $this->setBillingAddress($order->getBillingAddress());
        $this->setEmail($order->getEmail());
        //date of birth and gender should not be sent for firms, only for Private persons
        if ($isFirm) {
            $this->setCompanyOrPerson('F');
            //for companies, set billing firstname + billing lastname in reference#
            $this->setReference($order->getBillingAddress()->getFirstName() . ' ' . $order->getBillingAddress()->getLastName());
        } else {
            $this->setCompanyOrPerson('P');
            if ($order->getBillingAddress()->getSalutation() == 'Herr') {
                $this->setGender('m');
            } else {
                $this->setGender('f');
            }
        }

        $this->setKlarnaAction($klarnaAction);
    }

    /**
     * @ignore <description>
     * @param int $annualSalary
     */
    public function setAnnualSalary($annualSalary)
    {
        $this->AnnualSalary = $annualSalary;
    }

    /**
     * @ignore <description>
     * @return int
     */
    public function getAnnualSalary()
    {
        return $this->AnnualSalary;
    }

    /**
     * @ignore <description>
     * @param string $companyOrPerson
     */
    public function setCompanyOrPerson($companyOrPerson)
    {
        $this->CompanyOrPerson = $companyOrPerson;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getCompanyOrPerson()
    {
        return $this->CompanyOrPerson;
    }

    /**
     * @ignore <description>
     * @param string $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->DateOfBirth = $dateOfBirth;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->DateOfBirth;
    }

    /**
     * @ignore <description>
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->Email = $email;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @ignore <description>
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->Gender = $gender;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getGender()
    {
        return $this->Gender;
    }

    /**
     * @ignore <description>
     * @param string $invoiceFlag
     */
    public function setInvoiceFlag($invoiceFlag)
    {
        $this->InvoiceFlag = $invoiceFlag;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getInvoiceFlag()
    {
        return $this->InvoiceFlag;
    }

    /**
     * @ignore <description>
     * @param int $klarnaAction
     */
    public function setKlarnaAction($klarnaAction)
    {
        $this->KlarnaAction = $klarnaAction;
    }

    /**
     * @ignore <description>
     * @return int
     */
    public function getKlarnaAction()
    {
        return $this->KlarnaAction;
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
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->Phone = $phone;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @ignore <description>
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->Reference = $reference;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getReference()
    {
        return $this->Reference;
    }

    /**
     * @ignore <description>
     * @param string $socialSecurityNumber
     */
    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->SocialSecurityNumber = $socialSecurityNumber;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSocialSecurityNumber()
    {
        return $this->SocialSecurityNumber;
    }

    /**
     * @ignore <description>
     * @param string $bdCountryCode
     */
    public function setBdCountryCode($bdCountryCode)
    {
        $this->bdCountryCode = $bdCountryCode;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdCountryCode()
    {
        return $this->bdCountryCode;
    }

    /**
     * @ignore <description>
     * @param string $bdFirstName
     */
    public function setBdFirstName($bdFirstName)
    {
        $this->bdFirstName = $bdFirstName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdFirstName()
    {
        return $this->bdFirstName;
    }

    /**
     * @ignore <description>
     * @param string $bdLastName
     */
    public function setBdLastName($bdLastName)
    {
        $this->bdLastName = $bdLastName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdLastName()
    {
        return $this->bdLastName;
    }

    /**
     * @ignore <description>
     * @param string $bdStreet
     */
    public function setBdStreet($bdStreet)
    {
        $this->bdStreet = $bdStreet;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdStreet()
    {
        return $this->bdStreet;
    }

    /**
     * @ignore <description>
     * @param string $bdStreetNr
     */
    public function setBdStreetNr($bdStreetNr)
    {
        $this->bdStreetNr = $bdStreetNr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdStreetNr()
    {
        return $this->bdStreetNr;
    }

    /**
     * @ignore <description>
     * @param string $bdZip
     */
    public function setBdZip($bdZip)
    {
        $this->bdZip = $bdZip;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdZip()
    {
        return $this->bdZip;
    }

    /**
     * @ignore <description>
     * @param string $sdCity
     */
    public function setSdCity($sdCity)
    {
        $this->sdCity = $sdCity;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdCity()
    {
        return $this->sdCity;
    }

    /**
     * @ignore <description>
     * @param string $sdCountryCode
     */
    public function setSdCountryCode($sdCountryCode)
    {
        $this->sdCountryCode = $sdCountryCode;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdCountryCode()
    {
        return $this->sdCountryCode;
    }

    /**
     * @ignore <description>
     * @param string $sdFirstName
     */
    public function setSdFirstName($sdFirstName)
    {
        $this->sdFirstName = $sdFirstName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdFirstName()
    {
        return $this->sdFirstName;
    }

    /**
     * @ignore <description>
     * @param string $sdLastName
     */
    public function setSdLastName($sdLastName)
    {
        $this->sdLastName = $sdLastName;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdLastName()
    {
        return $this->sdLastName;
    }

    /**
     * @ignore <description>
     * @param string $sdStreet
     */
    public function setSdStreet($sdStreet)
    {
        $this->sdStreet = $sdStreet;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdStreet()
    {
        return $this->sdStreet;
    }

    /**
     * @ignore <description>
     * @param string $sdStreetNr
     */
    public function setSdStreetNr($sdStreetNr)
    {
        $this->sdStreetNr = $sdStreetNr;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getSdStreetNr()
    {
        return $this->sdStreetNr;
    }

    /**
     * @ignore <description>
     * @param string $bdCity
     */
    public function setBdCity($bdCity)
    {
        $this->bdCity = $bdCity;
    }

    /**
     * @ignore <description>
     * @return string
     */
    public function getBdCity()
    {
        return $this->bdCity;
    }

    /**
     * sets all address fields for shipping address
     * @param $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        //for companies, first name must be empty
        if ($shippingAddress->getCompany() == '') {
            $this->setSdFirstName($shippingAddress->getFirstName());
        }
        $this->setSdLastName($shippingAddress->getLastName());
        $this->setSdStreet($shippingAddress->getStreet());
        $this->setSdStreetNr($shippingAddress->getStreetNr());
        $this->setSdZip($shippingAddress->getZip());
        $this->setSdCity($shippingAddress->getCity());
        $this->setSdCountryCode($shippingAddress->getCountryCodeIso3());
    }

    /**
     * sets all address fields for shipping address
     * @param $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        //for companies, first name must be empty
        if ($billingAddress->getCompany() == '') {
            $this->setBDFirstName($billingAddress->getFirstName());
        }
        $this->setBdLastName($billingAddress->getLastName());
        $this->setBdStreet($billingAddress->getStreet());
        $this->setBdStreetNr($billingAddress->getStreetNr());
        $this->setBdZip($billingAddress->getZip());
        $this->setBdCity($billingAddress->getCity());
        $this->setBdCountryCode($billingAddress->getCountryCodeIso3());
    }


    /**
     * returns the PaymentUZRL
     * @return string
     */
    public function getCTPaymentURL()
    {
        return 'https://www.computop-paygate.com/Klarna.aspx';
    }

    /**
     * Zusätzlich können Sie per E-Mail eine Rechnung an den Endkunden versenden. Dazu rufen Sie fol-gende URL auf:
     * https://www.computop-paygate.com/KlarnaEmail.aspx
     *
     * @param $merchantID
     * @param $payID
     */
    public function sendEmailWithInvoice($merchantID, $payID)
    {
        // TODO - Implement this method
    }
}

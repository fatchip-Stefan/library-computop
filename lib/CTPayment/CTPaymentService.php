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

use Fatchip\CTPayment\CTCrif\CRIF;
use Fatchip\CTPayment\CTPaymentMethodsIframe\Sofort;
use Fatchip\CTPayment\CTResponse;

class CTPaymentService extends Blowfish
{
    public function __construct(
        $config
    )
    {
        $this->merchantID = $config['merchantID'];
        $this->blowfishPassword = $config['blowfishPassword'];
        $this->mac = $config['mac'];
    }

    public function getIframePaymentClass($className, $config, $ctOrder = null, $urlSuccess = null, $urlFailure = null, $urlNotify = null, $orderDesc = null, $userData = null, $eventToken = null, $isFirm = null, $klarnainvoice = null)
    {
        //Ideal can be called directly, or via Sofort with SofortAction=ideal.
        //If set to 'via sofort' in Pluginsettings, return a class of type Sofort with Sofortaction = ideal
        if ($className == 'Ideal' && $config['idealDirektOderUeberSofort'] == 'SOFORT') {
            $obj = new Sofort($config, $ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData);
            $obj->setSofortAction('ideal');
            return $obj;
        }

        //Lastschrift is an abstract class and cannot be instantiated directly
        if ($className == 'Lastschrift') {
            if ($config['lastschriftDienst'] == 'EVO') {
                $className = 'LastschriftEVO';
            } else if ($config['lastschriftDienst'] == 'DIREKT') {
                $className = 'LastschriftDirekt';
            } else if ($config['lastschriftDienst'] == 'INTERCARD') {
                $className = 'LastschriftInterCard';
            }
        }

        $class = 'Fatchip\\CTPayment\\CTPaymentMethodsIframe\\' . $className;
        return new $class($config, $ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData, $eventToken, $isFirm, $klarnainvoice);
    }

    public function getPaymentClass($className, $config, $ctOrder = null, $urlSuccess = null, $urlFailure = null, $urlNotify = null, $orderDesc, $userData = null)
    {
        $class = 'Fatchip\\CTPayment\\CTPaymentMethods\\' . $className;
        return new $class($config, $ctOrder, $urlSuccess, $urlFailure, $urlNotify, $orderDesc, $userData);
    }

    public function getCRIFClass($config, $order, $orderDesc, $userData)
    {
        return new CRIF($config, $order, $orderDesc, $userData);
    }

    public function getPaymentConfigForms()
    {
        return new CTPaymentConfigForms();
    }

    public function getDecryptedResponse(array $rawRequest)
    {
        $decryptedRequest = $this->ctDecrypt($rawRequest['Data'], $rawRequest['Len'], $this->blowfishPassword);
        $requestArray = $this->ctSplit(explode('&', $decryptedRequest), '=');
        $response = new CTResponse($requestArray);
        return $response;
    }

    public function getPaymentMethods()
    {
        return CTPaymentMethods::paymentMethods;
    }
}

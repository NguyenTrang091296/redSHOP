<?php
/**
 * @copyright Copyright (C) 2010 redCOMPONENT.com. All rights reserved.
 * @license   GNU/GPL, see license.txt or http://www.gnu.org/copyleft/gpl.html
 *            Developed by email@recomponent.com - redCOMPONENT.com
 *
 * redSHOP can be downloaded from www.redcomponent.com
 * redSHOP is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.
 *
 * You should have received a copy of the GNU General Public License
 * along with redSHOP; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
require_once JPATH_COMPONENT . DS . 'helpers' . DS . 'helper.php';
$redhelper = new redhelper;
$db = JFactory::getDBO();
$user = JFActory::getUser();
$task = JRequest::getVar('task');
$mainframe =& JFactory::getApplication();
$Itemid = $_REQUEST['Itemid'];
//Authnet vars to send
$formdata = array(
	'merchant'  => $this->_params->get("access_id"),
	'token'     => $this->_params->get("token_id"),
	'orderid'   => $data['order_id'],
	'accepturl' => JURI::base() . "index.php?option=com_redshop&view=order_detail&controller=order_detail&Itemid=$Itemid&task=notify_payment&payment_plugin=rs_payment_bbs&orderid=" . $data['order_id']);

/* extra info */
if ($this->_params->get("is_test") == "TRUE")
	$formdata['test'] = "yes";

$version = "2";

if ($this->_params->get("is_test") == "TRUE")
{
	$bbsurl = "https://epayment-test.bbs.no/Netaxept/Register.aspx?";
}
else
{
	$bbsurl = "https://epayment.bbs.no/Netaxept/Register.aspx?";
}


$currency = new convertPrice;
$data['carttotal'] *= 100;
$amount = $currency->convert($data['carttotal'], '', 'NOK');
//$amount = $currency->convert(number_format($order->order_total,PRICE_DECIMAL,PRICE_SEPERATOR,THOUSAND_SEPERATOR),'','NOK');

$bbsurl .= "merchantId=" . urlencode($formdata['merchant']) . "&token=" . urlencode($formdata['token']) . "&orderNumber=" . $formdata['orderid'] . "&amount=" . urlencode(intval($amount)) . "&currencyCode=NOK&redirectUrl=" . urlencode($formdata['accepturl']) . "";
$data = $bbsurl;


// Create a curl handle to a non-existing location
$ch = curl_init($data);

// Execute
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);

if ($this->_params->get("is_test") == "TRUE")
{
	$bbsurl = "https://epayment-test.bbs.no/Terminal/default.aspx?";
}
else
{
	$bbsurl = "https://epayment.bbs.no/Terminal/default.aspx?";
}

$xml = new SimpleXMLElement($data);
$TransactionId = $xml->TransactionId;
$bbsurl .= "merchantId=" . urlencode($formdata['merchant']);
$bbsurl .= "&transactionId=" . $TransactionId;

$mainframe->redirect($bbsurl);

?>
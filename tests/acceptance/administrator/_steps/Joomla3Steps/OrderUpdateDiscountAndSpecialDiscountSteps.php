<?php
/**
 * @package     redSHOP
 * @subpackage  Step Class
 * @copyright   Copyright (C) 2008 - 2020 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace AcceptanceTester;

use OrderManagerPage;

/**
 * Class ProductManagerJoomla3Steps
 *
 * @package  AcceptanceTester
 *
 * @link     http://codeception.com/docs/07-AdvancedUsage#StepObjects
 *
 * @since    2.1.3
 */
class OrderUpdateDiscountAndSpecialDiscountSteps extends OrderManagerJoomla3Steps
{
	/**
	 * @param $userName
	 * @param $productName
	 * @param $firstName
	 * @param $address
	 * @param $zipCode
	 * @param $city
	 * @param $phone
	 * @param $discountUpdate
	 * @param $specialUpdate
	 * @param $randomProductPrice
	 * @throws \Exception
	 * @since 2.1.3
	 */
	public function updateDiscountAndSpecialDiscount($userName, $productName, $firstName, $address, $zipCode, $city, $phone, $discountUpdate, $specialUpdate, $randomProductPrice)
	{
		$I = $this;
		$I->amOnPage(OrderManagerPage::$URL);
		$I->click(OrderManagerPage::$buttonNew);
		$I->waitForText(OrderManagerPage::$titlePage, 30);
		$I->waitForElementVisible(OrderManagerPage::$userId, 30);
		$I->click(OrderManagerPage::$userId);
		$I->waitForElementVisible(OrderManagerPage::$userSearch, 30);
		$userOrderPage = new OrderManagerPage();
		$I->fillField(OrderManagerPage::$userSearch, $userName);
		$I->waitForElement($userOrderPage->returnSearch($userName), 30);
		$I->pressKey(OrderManagerPage::$userSearch, \Facebook\WebDriver\WebDriverKeys::ENTER);
		$I->waitForElement(OrderManagerPage::$fistName, 30);
		$I->see($userName);
		$I->wait(1.5);
		$I->waitForElement(OrderManagerPage::$address, 30);
		$I->waitForElementVisible(OrderManagerPage::$address, 30);
		$I->fillField(OrderManagerPage::$address, $address);
		$I->fillField(OrderManagerPage::$zipcode, $zipCode);
		$I->fillField(OrderManagerPage::$city, $city);
		$I->fillField(OrderManagerPage::$phone, $phone);
		$I->waitForElement(OrderManagerPage::$applyUser, 30);
		$I->executeJS("jQuery('.button-apply').click()");
		$I->waitForElementVisible(OrderManagerPage::$orderDetailTable, 30);
		$I->scrollTo(OrderManagerPage::$orderDetailTable);
		$I->waitForElementVisible(OrderManagerPage::$productId, 30);
		$I->click(OrderManagerPage::$productId);
		$I->waitForElementVisible(OrderManagerPage::$productsSearch, 60);
		$I->fillField(OrderManagerPage::$productsSearch, $productName);
		$I->waitForElementVisible($userOrderPage->returnSearch($productName), 30);
		$I->click($userOrderPage->returnSearch($productName));
		$I->waitForText($randomProductPrice, 30);
		$I->executeJS('window.scrollTo(0,0);');
		$I->click(OrderManagerPage::$buttonSavePay);
		$I->waitForText(OrderManagerPage::$buttonClose, 30);
		$I->click(OrderManagerPage::$buttonClose);
		$I->searchOrder($firstName);
		$id = $I->grabTextFrom(OrderManagerPage::$orderID);
		$I->fillField(OrderManagerPage::$filter, $firstName);
		$I->click(OrderManagerPage::$orderID);
		$I->waitForElementVisible(OrderManagerPage::$orderDetailTitle, 30);
		$I->scrollTo(OrderManagerPage::$orderDetailTitle);
		$I->waitForElementVisible(OrderManagerPage::$discountUpdate, 30);
		$I->fillField(OrderManagerPage::$discountUpdate, $discountUpdate);
		$I->waitForElementVisible($userOrderPage->returnButtonUpdateDiscount($id), 30);
		$I->click($userOrderPage->returnButtonUpdateDiscount($id));
		$I->waitForElementVisible(OrderManagerPage::$selectorSuccess, 30);
		$I->waitForElementVisible(OrderManagerPage::$orderDetailTitle, 30);
		$I->scrollTo(OrderManagerPage::$orderDetailTitle);
		$I->waitForElementVisible(OrderManagerPage::$specialUpdate, 30);
		$I->fillField(OrderManagerPage::$specialUpdate, $specialUpdate);
		$I->waitForElementVisible($userOrderPage->returnButtonSpecialDiscount($id), 30);
		$I->click($userOrderPage->returnButtonSpecialDiscount($id));
		$I->waitForElementVisible(OrderManagerPage::$selectorSuccess, 30);
		$adminFinalPriceEnd = $randomProductPrice - ($discountUpdate + (($specialUpdate/100) * $randomProductPrice));
		$I->see($adminFinalPriceEnd);
		$I->executeJS('window.scrollTo(0,0);');
		$I->waitForElement(OrderManagerPage::$close, 30);
		$I->waitForText(OrderManagerPage::$buttonClose, 10, OrderManagerPage::$close);
	}
}

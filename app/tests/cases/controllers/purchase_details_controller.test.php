<?php 
/* SVN FILE: $Id$ */
/* PurchaseDetailsController Test cases generated on: 2009-08-08 18:08:12 : 1249725192*/
App::import('Controller', 'PurchaseDetails');

class TestPurchaseDetails extends PurchaseDetailsController {
	var $autoRender = false;
}

class PurchaseDetailsControllerTest extends CakeTestCase {
	var $PurchaseDetails = null;

	function startTest() {
		$this->PurchaseDetails = new TestPurchaseDetails();
		$this->PurchaseDetails->constructClasses();
	}

	function testPurchaseDetailsControllerInstance() {
		$this->assertTrue(is_a($this->PurchaseDetails, 'PurchaseDetailsController'));
	}

	function endTest() {
		unset($this->PurchaseDetails);
	}
}
?>
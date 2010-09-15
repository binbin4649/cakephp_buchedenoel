<?php 
/* SVN FILE: $Id$ */
/* PurchasesController Test cases generated on: 2009-08-08 18:08:29 : 1249724909*/
App::import('Controller', 'Purchases');

class TestPurchases extends PurchasesController {
	var $autoRender = false;
}

class PurchasesControllerTest extends CakeTestCase {
	var $Purchases = null;

	function startTest() {
		$this->Purchases = new TestPurchases();
		$this->Purchases->constructClasses();
	}

	function testPurchasesControllerInstance() {
		$this->assertTrue(is_a($this->Purchases, 'PurchasesController'));
	}

	function endTest() {
		unset($this->Purchases);
	}
}
?>
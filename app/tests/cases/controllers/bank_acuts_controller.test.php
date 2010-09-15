<?php 
/* SVN FILE: $Id$ */
/* BankAcutsController Test cases generated on: 2009-08-08 19:08:48 : 1249727388*/
App::import('Controller', 'BankAcuts');

class TestBankAcuts extends BankAcutsController {
	var $autoRender = false;
}

class BankAcutsControllerTest extends CakeTestCase {
	var $BankAcuts = null;

	function startTest() {
		$this->BankAcuts = new TestBankAcuts();
		$this->BankAcuts->constructClasses();
	}

	function testBankAcutsControllerInstance() {
		$this->assertTrue(is_a($this->BankAcuts, 'BankAcutsController'));
	}

	function endTest() {
		unset($this->BankAcuts);
	}
}
?>
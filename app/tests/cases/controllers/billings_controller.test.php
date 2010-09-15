<?php 
/* SVN FILE: $Id$ */
/* BillingsController Test cases generated on: 2009-08-08 17:08:53 : 1249721273*/
App::import('Controller', 'Billings');

class TestBillings extends BillingsController {
	var $autoRender = false;
}

class BillingsControllerTest extends CakeTestCase {
	var $Billings = null;

	function startTest() {
		$this->Billings = new TestBillings();
		$this->Billings->constructClasses();
	}

	function testBillingsControllerInstance() {
		$this->assertTrue(is_a($this->Billings, 'BillingsController'));
	}

	function endTest() {
		unset($this->Billings);
	}
}
?>
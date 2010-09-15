<?php 
/* SVN FILE: $Id$ */
/* InvoiceDateilsController Test cases generated on: 2009-08-08 19:08:34 : 1249727194*/
App::import('Controller', 'InvoiceDateils');

class TestInvoiceDateils extends InvoiceDateilsController {
	var $autoRender = false;
}

class InvoiceDateilsControllerTest extends CakeTestCase {
	var $InvoiceDateils = null;

	function startTest() {
		$this->InvoiceDateils = new TestInvoiceDateils();
		$this->InvoiceDateils->constructClasses();
	}

	function testInvoiceDateilsControllerInstance() {
		$this->assertTrue(is_a($this->InvoiceDateils, 'InvoiceDateilsController'));
	}

	function endTest() {
		unset($this->InvoiceDateils);
	}
}
?>
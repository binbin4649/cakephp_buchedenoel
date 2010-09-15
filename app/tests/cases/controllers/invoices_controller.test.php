<?php 
/* SVN FILE: $Id$ */
/* InvoicesController Test cases generated on: 2009-08-08 19:08:51 : 1249726911*/
App::import('Controller', 'Invoices');

class TestInvoices extends InvoicesController {
	var $autoRender = false;
}

class InvoicesControllerTest extends CakeTestCase {
	var $Invoices = null;

	function startTest() {
		$this->Invoices = new TestInvoices();
		$this->Invoices->constructClasses();
	}

	function testInvoicesControllerInstance() {
		$this->assertTrue(is_a($this->Invoices, 'InvoicesController'));
	}

	function endTest() {
		unset($this->Invoices);
	}
}
?>
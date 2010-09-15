<?php 
/* SVN FILE: $Id$ */
/* SalesStateCodesController Test cases generated on: 2009-06-15 15:06:12 : 1245048072*/
App::import('Controller', 'SalesStateCodes');

class TestSalesStateCodes extends SalesStateCodesController {
	var $autoRender = false;
}

class SalesStateCodesControllerTest extends CakeTestCase {
	var $SalesStateCodes = null;

	function startTest() {
		$this->SalesStateCodes = new TestSalesStateCodes();
		$this->SalesStateCodes->constructClasses();
	}

	function testSalesStateCodesControllerInstance() {
		$this->assertTrue(is_a($this->SalesStateCodes, 'SalesStateCodesController'));
	}

	function endTest() {
		unset($this->SalesStateCodes);
	}
}
?>
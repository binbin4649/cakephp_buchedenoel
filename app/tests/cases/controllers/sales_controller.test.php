<?php 
/* SVN FILE: $Id$ */
/* SalesController Test cases generated on: 2009-08-08 19:08:14 : 1249726154*/
App::import('Controller', 'Sales');

class TestSales extends SalesController {
	var $autoRender = false;
}

class SalesControllerTest extends CakeTestCase {
	var $Sales = null;

	function startTest() {
		$this->Sales = new TestSales();
		$this->Sales->constructClasses();
	}

	function testSalesControllerInstance() {
		$this->assertTrue(is_a($this->Sales, 'SalesController'));
	}

	function endTest() {
		unset($this->Sales);
	}
}
?>
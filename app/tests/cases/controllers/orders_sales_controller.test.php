<?php 
/* SVN FILE: $Id$ */
/* OrdersSalesController Test cases generated on: 2009-08-08 19:08:21 : 1249725861*/
App::import('Controller', 'OrdersSales');

class TestOrdersSales extends OrdersSalesController {
	var $autoRender = false;
}

class OrdersSalesControllerTest extends CakeTestCase {
	var $OrdersSales = null;

	function startTest() {
		$this->OrdersSales = new TestOrdersSales();
		$this->OrdersSales->constructClasses();
	}

	function testOrdersSalesControllerInstance() {
		$this->assertTrue(is_a($this->OrdersSales, 'OrdersSalesController'));
	}

	function endTest() {
		unset($this->OrdersSales);
	}
}
?>
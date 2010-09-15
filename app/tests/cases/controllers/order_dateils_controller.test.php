<?php 
/* SVN FILE: $Id$ */
/* OrderDateilsController Test cases generated on: 2009-08-08 19:08:36 : 1249725696*/
App::import('Controller', 'OrderDateils');

class TestOrderDateils extends OrderDateilsController {
	var $autoRender = false;
}

class OrderDateilsControllerTest extends CakeTestCase {
	var $OrderDateils = null;

	function startTest() {
		$this->OrderDateils = new TestOrderDateils();
		$this->OrderDateils->constructClasses();
	}

	function testOrderDateilsControllerInstance() {
		$this->assertTrue(is_a($this->OrderDateils, 'OrderDateilsController'));
	}

	function endTest() {
		unset($this->OrderDateils);
	}
}
?>
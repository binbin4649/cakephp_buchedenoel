<?php 
/* SVN FILE: $Id$ */
/* OrderingsDetailsController Test cases generated on: 2009-08-08 18:08:11 : 1249724831*/
App::import('Controller', 'OrderingsDetails');

class TestOrderingsDetails extends OrderingsDetailsController {
	var $autoRender = false;
}

class OrderingsDetailsControllerTest extends CakeTestCase {
	var $OrderingsDetails = null;

	function startTest() {
		$this->OrderingsDetails = new TestOrderingsDetails();
		$this->OrderingsDetails->constructClasses();
	}

	function testOrderingsDetailsControllerInstance() {
		$this->assertTrue(is_a($this->OrderingsDetails, 'OrderingsDetailsController'));
	}

	function endTest() {
		unset($this->OrderingsDetails);
	}
}
?>
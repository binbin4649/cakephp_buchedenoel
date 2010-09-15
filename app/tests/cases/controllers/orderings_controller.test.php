<?php 
/* SVN FILE: $Id$ */
/* OrderingsController Test cases generated on: 2009-08-08 18:08:09 : 1249724709*/
App::import('Controller', 'Orderings');

class TestOrderings extends OrderingsController {
	var $autoRender = false;
}

class OrderingsControllerTest extends CakeTestCase {
	var $Orderings = null;

	function startTest() {
		$this->Orderings = new TestOrderings();
		$this->Orderings->constructClasses();
	}

	function testOrderingsControllerInstance() {
		$this->assertTrue(is_a($this->Orderings, 'OrderingsController'));
	}

	function endTest() {
		unset($this->Orderings);
	}
}
?>
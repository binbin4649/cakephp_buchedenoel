<?php 
/* SVN FILE: $Id$ */
/* DaysCoordinationsController Test cases generated on: 2009-06-15 15:06:38 : 1245048158*/
App::import('Controller', 'DaysCoordinations');

class TestDaysCoordinations extends DaysCoordinationsController {
	var $autoRender = false;
}

class DaysCoordinationsControllerTest extends CakeTestCase {
	var $DaysCoordinations = null;

	function startTest() {
		$this->DaysCoordinations = new TestDaysCoordinations();
		$this->DaysCoordinations->constructClasses();
	}

	function testDaysCoordinationsControllerInstance() {
		$this->assertTrue(is_a($this->DaysCoordinations, 'DaysCoordinationsController'));
	}

	function endTest() {
		unset($this->DaysCoordinations);
	}
}
?>
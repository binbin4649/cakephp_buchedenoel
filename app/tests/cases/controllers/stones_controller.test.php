<?php 
/* SVN FILE: $Id$ */
/* StonesController Test cases generated on: 2009-06-15 15:06:03 : 1245048243*/
App::import('Controller', 'Stones');

class TestStones extends StonesController {
	var $autoRender = false;
}

class StonesControllerTest extends CakeTestCase {
	var $Stones = null;

	function startTest() {
		$this->Stones = new TestStones();
		$this->Stones->constructClasses();
	}

	function testStonesControllerInstance() {
		$this->assertTrue(is_a($this->Stones, 'StonesController'));
	}

	function endTest() {
		unset($this->Stones);
	}
}
?>
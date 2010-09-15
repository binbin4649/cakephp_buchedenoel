<?php 
/* SVN FILE: $Id$ */
/* PairsController Test cases generated on: 2009-06-15 15:06:34 : 1245048334*/
App::import('Controller', 'Pairs');

class TestPairs extends PairsController {
	var $autoRender = false;
}

class PairsControllerTest extends CakeTestCase {
	var $Pairs = null;

	function startTest() {
		$this->Pairs = new TestPairs();
		$this->Pairs->constructClasses();
	}

	function testPairsControllerInstance() {
		$this->assertTrue(is_a($this->Pairs, 'PairsController'));
	}

	function endTest() {
		unset($this->Pairs);
	}
}
?>
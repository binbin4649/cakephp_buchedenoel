<?php 
/* SVN FILE: $Id$ */
/* PartsController Test cases generated on: 2009-06-15 15:06:05 : 1245048005*/
App::import('Controller', 'Parts');

class TestParts extends PartsController {
	var $autoRender = false;
}

class PartsControllerTest extends CakeTestCase {
	var $Parts = null;

	function startTest() {
		$this->Parts = new TestParts();
		$this->Parts->constructClasses();
	}

	function testPartsControllerInstance() {
		$this->assertTrue(is_a($this->Parts, 'PartsController'));
	}

	function endTest() {
		unset($this->Parts);
	}
}
?>
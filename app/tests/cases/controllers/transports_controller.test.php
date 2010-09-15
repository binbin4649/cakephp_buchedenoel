<?php 
/* SVN FILE: $Id$ */
/* TransportsController Test cases generated on: 2009-08-08 18:08:23 : 1249724483*/
App::import('Controller', 'Transports');

class TestTransports extends TransportsController {
	var $autoRender = false;
}

class TransportsControllerTest extends CakeTestCase {
	var $Transports = null;

	function startTest() {
		$this->Transports = new TestTransports();
		$this->Transports->constructClasses();
	}

	function testTransportsControllerInstance() {
		$this->assertTrue(is_a($this->Transports, 'TransportsController'));
	}

	function endTest() {
		unset($this->Transports);
	}
}
?>
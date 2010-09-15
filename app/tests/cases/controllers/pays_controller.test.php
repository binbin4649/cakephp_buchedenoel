<?php 
/* SVN FILE: $Id$ */
/* PaysController Test cases generated on: 2009-08-08 18:08:48 : 1249725348*/
App::import('Controller', 'Pays');

class TestPays extends PaysController {
	var $autoRender = false;
}

class PaysControllerTest extends CakeTestCase {
	var $Pays = null;

	function startTest() {
		$this->Pays = new TestPays();
		$this->Pays->constructClasses();
	}

	function testPaysControllerInstance() {
		$this->assertTrue(is_a($this->Pays, 'PaysController'));
	}

	function endTest() {
		unset($this->Pays);
	}
}
?>
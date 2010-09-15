<?php 
/* SVN FILE: $Id$ */
/* DepotsController Test cases generated on: 2009-08-08 18:08:38 : 1249723958*/
App::import('Controller', 'Depots');

class TestDepots extends DepotsController {
	var $autoRender = false;
}

class DepotsControllerTest extends CakeTestCase {
	var $Depots = null;

	function startTest() {
		$this->Depots = new TestDepots();
		$this->Depots->constructClasses();
	}

	function testDepotsControllerInstance() {
		$this->assertTrue(is_a($this->Depots, 'DepotsController'));
	}

	function endTest() {
		unset($this->Depots);
	}
}
?>
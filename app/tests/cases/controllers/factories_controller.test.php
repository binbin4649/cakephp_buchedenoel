<?php 
/* SVN FILE: $Id$ */
/* FactoriesController Test cases generated on: 2009-06-15 15:06:33 : 1245047853*/
App::import('Controller', 'Factories');

class TestFactories extends FactoriesController {
	var $autoRender = false;
}

class FactoriesControllerTest extends CakeTestCase {
	var $Factories = null;

	function startTest() {
		$this->Factories = new TestFactories();
		$this->Factories->constructClasses();
	}

	function testFactoriesControllerInstance() {
		$this->assertTrue(is_a($this->Factories, 'FactoriesController'));
	}

	function endTest() {
		unset($this->Factories);
	}
}
?>
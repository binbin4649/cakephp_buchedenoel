<?php 
/* SVN FILE: $Id$ */
/* InventoriesController Test cases generated on: 2009-08-08 18:08:05 : 1249724225*/
App::import('Controller', 'Inventories');

class TestInventories extends InventoriesController {
	var $autoRender = false;
}

class InventoriesControllerTest extends CakeTestCase {
	var $Inventories = null;

	function startTest() {
		$this->Inventories = new TestInventories();
		$this->Inventories->constructClasses();
	}

	function testInventoriesControllerInstance() {
		$this->assertTrue(is_a($this->Inventories, 'InventoriesController'));
	}

	function endTest() {
		unset($this->Inventories);
	}
}
?>
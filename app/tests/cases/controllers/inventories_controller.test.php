<?php 
/* SVN FILE: $Id$ */
/* InventoriesController Test cases generated on: 2010-11-02 16:11:10 : 1288684150*/
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
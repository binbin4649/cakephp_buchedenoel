<?php 
/* SVN FILE: $Id$ */
/* ItemsController Test cases generated on: 2009-06-15 15:06:20 : 1245047900*/
App::import('Controller', 'Items');

class TestItems extends ItemsController {
	var $autoRender = false;
}

class ItemsControllerTest extends CakeTestCase {
	var $Items = null;

	function startTest() {
		$this->Items = new TestItems();
		$this->Items->constructClasses();
	}

	function testItemsControllerInstance() {
		$this->assertTrue(is_a($this->Items, 'ItemsController'));
	}

	function endTest() {
		unset($this->Items);
	}
}
?>
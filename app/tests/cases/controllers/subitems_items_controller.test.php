<?php 
/* SVN FILE: $Id$ */
/* SubitemsItemsController Test cases generated on: 2009-06-09 18:06:34 : 1244541394*/
App::import('Controller', 'SubitemsItems');

class TestSubitemsItems extends SubitemsItemsController {
	var $autoRender = false;
}

class SubitemsItemsControllerTest extends CakeTestCase {
	var $SubitemsItems = null;

	function startTest() {
		$this->SubitemsItems = new TestSubitemsItems();
		$this->SubitemsItems->constructClasses();
	}

	function testSubitemsItemsControllerInstance() {
		$this->assertTrue(is_a($this->SubitemsItems, 'SubitemsItemsController'));
	}

	function endTest() {
		unset($this->SubitemsItems);
	}
}
?>
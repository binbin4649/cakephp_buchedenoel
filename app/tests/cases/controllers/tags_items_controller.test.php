<?php 
/* SVN FILE: $Id$ */
/* TagsItemsController Test cases generated on: 2009-06-15 15:06:56 : 1245048296*/
App::import('Controller', 'TagsItems');

class TestTagsItems extends TagsItemsController {
	var $autoRender = false;
}

class TagsItemsControllerTest extends CakeTestCase {
	var $TagsItems = null;

	function startTest() {
		$this->TagsItems = new TestTagsItems();
		$this->TagsItems->constructClasses();
	}

	function testTagsItemsControllerInstance() {
		$this->assertTrue(is_a($this->TagsItems, 'TagsItemsController'));
	}

	function endTest() {
		unset($this->TagsItems);
	}
}
?>
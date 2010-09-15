<?php 
/* SVN FILE: $Id$ */
/* MemoCategoriesController Test cases generated on: 2009-07-24 12:07:52 : 1248405832*/
App::import('Controller', 'MemoCategories');

class TestMemoCategories extends MemoCategoriesController {
	var $autoRender = false;
}

class MemoCategoriesControllerTest extends CakeTestCase {
	var $MemoCategories = null;

	function startTest() {
		$this->MemoCategories = new TestMemoCategories();
		$this->MemoCategories->constructClasses();
	}

	function testMemoCategoriesControllerInstance() {
		$this->assertTrue(is_a($this->MemoCategories, 'MemoCategoriesController'));
	}

	function endTest() {
		unset($this->MemoCategories);
	}
}
?>
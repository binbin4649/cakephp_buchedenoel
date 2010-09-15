<?php 
/* SVN FILE: $Id$ */
/* SubitemsController Test cases generated on: 2009-06-15 15:06:23 : 1245047963*/
App::import('Controller', 'Subitems');

class TestSubitems extends SubitemsController {
	var $autoRender = false;
}

class SubitemsControllerTest extends CakeTestCase {
	var $Subitems = null;

	function startTest() {
		$this->Subitems = new TestSubitems();
		$this->Subitems->constructClasses();
	}

	function testSubitemsControllerInstance() {
		$this->assertTrue(is_a($this->Subitems, 'SubitemsController'));
	}

	function endTest() {
		unset($this->Subitems);
	}
}
?>
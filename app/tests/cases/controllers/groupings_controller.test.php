<?php 
/* SVN FILE: $Id$ */
/* GroupingsController Test cases generated on: 2009-08-08 18:08:26 : 1249723166*/
App::import('Controller', 'Groupings');

class TestGroupings extends GroupingsController {
	var $autoRender = false;
}

class GroupingsControllerTest extends CakeTestCase {
	var $Groupings = null;

	function startTest() {
		$this->Groupings = new TestGroupings();
		$this->Groupings->constructClasses();
	}

	function testGroupingsControllerInstance() {
		$this->assertTrue(is_a($this->Groupings, 'GroupingsController'));
	}

	function endTest() {
		unset($this->Groupings);
	}
}
?>
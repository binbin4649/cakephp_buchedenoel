<?php 
/* SVN FILE: $Id$ */
/* EmploymentsController Test cases generated on: 2009-06-15 15:06:06 : 1245047766*/
App::import('Controller', 'Employments');

class TestEmployments extends EmploymentsController {
	var $autoRender = false;
}

class EmploymentsControllerTest extends CakeTestCase {
	var $Employments = null;

	function startTest() {
		$this->Employments = new TestEmployments();
		$this->Employments->constructClasses();
	}

	function testEmploymentsControllerInstance() {
		$this->assertTrue(is_a($this->Employments, 'EmploymentsController'));
	}

	function endTest() {
		unset($this->Employments);
	}
}
?>
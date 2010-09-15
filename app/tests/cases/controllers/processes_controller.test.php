<?php 
/* SVN FILE: $Id$ */
/* ProcessesController Test cases generated on: 2009-06-15 15:06:05 : 1245048185*/
App::import('Controller', 'Processes');

class TestProcesses extends ProcessesController {
	var $autoRender = false;
}

class ProcessesControllerTest extends CakeTestCase {
	var $Processes = null;

	function startTest() {
		$this->Processes = new TestProcesses();
		$this->Processes->constructClasses();
	}

	function testProcessesControllerInstance() {
		$this->assertTrue(is_a($this->Processes, 'ProcessesController'));
	}

	function endTest() {
		unset($this->Processes);
	}
}
?>
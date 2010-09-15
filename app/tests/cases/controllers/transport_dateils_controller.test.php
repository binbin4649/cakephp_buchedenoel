<?php 
/* SVN FILE: $Id$ */
/* TransportDateilsController Test cases generated on: 2009-08-08 18:08:53 : 1249724573*/
App::import('Controller', 'TransportDateils');

class TestTransportDateils extends TransportDateilsController {
	var $autoRender = false;
}

class TransportDateilsControllerTest extends CakeTestCase {
	var $TransportDateils = null;

	function startTest() {
		$this->TransportDateils = new TestTransportDateils();
		$this->TransportDateils->constructClasses();
	}

	function testTransportDateilsControllerInstance() {
		$this->assertTrue(is_a($this->TransportDateils, 'TransportDateilsController'));
	}

	function endTest() {
		unset($this->TransportDateils);
	}
}
?>
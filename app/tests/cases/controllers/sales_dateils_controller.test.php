<?php 
/* SVN FILE: $Id$ */
/* SalesDateilsController Test cases generated on: 2009-08-08 19:08:57 : 1249726737*/
App::import('Controller', 'SalesDateils');

class TestSalesDateils extends SalesDateilsController {
	var $autoRender = false;
}

class SalesDateilsControllerTest extends CakeTestCase {
	var $SalesDateils = null;

	function startTest() {
		$this->SalesDateils = new TestSalesDateils();
		$this->SalesDateils->constructClasses();
	}

	function testSalesDateilsControllerInstance() {
		$this->assertTrue(is_a($this->SalesDateils, 'SalesDateilsController'));
	}

	function endTest() {
		unset($this->SalesDateils);
	}
}
?>
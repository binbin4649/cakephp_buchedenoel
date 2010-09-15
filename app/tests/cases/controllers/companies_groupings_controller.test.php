<?php 
/* SVN FILE: $Id$ */
/* CompaniesGroupingsController Test cases generated on: 2009-08-08 19:08:23 : 1249725803*/
App::import('Controller', 'CompaniesGroupings');

class TestCompaniesGroupings extends CompaniesGroupingsController {
	var $autoRender = false;
}

class CompaniesGroupingsControllerTest extends CakeTestCase {
	var $CompaniesGroupings = null;

	function startTest() {
		$this->CompaniesGroupings = new TestCompaniesGroupings();
		$this->CompaniesGroupings->constructClasses();
	}

	function testCompaniesGroupingsControllerInstance() {
		$this->assertTrue(is_a($this->CompaniesGroupings, 'CompaniesGroupingsController'));
	}

	function endTest() {
		unset($this->CompaniesGroupings);
	}
}
?>
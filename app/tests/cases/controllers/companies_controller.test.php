<?php 
/* SVN FILE: $Id$ */
/* CompaniesController Test cases generated on: 2009-08-08 18:08:42 : 1249722522*/
App::import('Controller', 'Companies');

class TestCompanies extends CompaniesController {
	var $autoRender = false;
}

class CompaniesControllerTest extends CakeTestCase {
	var $Companies = null;

	function startTest() {
		$this->Companies = new TestCompanies();
		$this->Companies->constructClasses();
	}

	function testCompaniesControllerInstance() {
		$this->assertTrue(is_a($this->Companies, 'CompaniesController'));
	}

	function endTest() {
		unset($this->Companies);
	}
}
?>
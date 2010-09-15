<?php 
/* SVN FILE: $Id$ */
/* BrandRatesController Test cases generated on: 2009-08-08 18:08:32 : 1249722812*/
App::import('Controller', 'BrandRates');

class TestBrandRates extends BrandRatesController {
	var $autoRender = false;
}

class BrandRatesControllerTest extends CakeTestCase {
	var $BrandRates = null;

	function startTest() {
		$this->BrandRates = new TestBrandRates();
		$this->BrandRates->constructClasses();
	}

	function testBrandRatesControllerInstance() {
		$this->assertTrue(is_a($this->BrandRates, 'BrandRatesController'));
	}

	function endTest() {
		unset($this->BrandRates);
	}
}
?>
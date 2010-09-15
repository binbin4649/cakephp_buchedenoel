<?php 
/* SVN FILE: $Id$ */
/* BrandsController Test cases generated on: 2009-06-15 15:06:17 : 1245048317*/
App::import('Controller', 'Brands');

class TestBrands extends BrandsController {
	var $autoRender = false;
}

class BrandsControllerTest extends CakeTestCase {
	var $Brands = null;

	function startTest() {
		$this->Brands = new TestBrands();
		$this->Brands->constructClasses();
	}

	function testBrandsControllerInstance() {
		$this->assertTrue(is_a($this->Brands, 'BrandsController'));
	}

	function endTest() {
		unset($this->Brands);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* MaterialsController Test cases generated on: 2009-06-15 15:06:39 : 1245048219*/
App::import('Controller', 'Materials');

class TestMaterials extends MaterialsController {
	var $autoRender = false;
}

class MaterialsControllerTest extends CakeTestCase {
	var $Materials = null;

	function startTest() {
		$this->Materials = new TestMaterials();
		$this->Materials->constructClasses();
	}

	function testMaterialsControllerInstance() {
		$this->assertTrue(is_a($this->Materials, 'MaterialsController'));
	}

	function endTest() {
		unset($this->Materials);
	}
}
?>
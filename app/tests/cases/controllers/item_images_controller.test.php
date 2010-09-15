<?php 
/* SVN FILE: $Id$ */
/* ItemImagesController Test cases generated on: 2009-06-15 15:06:35 : 1245048035*/
App::import('Controller', 'ItemImages');

class TestItemImages extends ItemImagesController {
	var $autoRender = false;
}

class ItemImagesControllerTest extends CakeTestCase {
	var $ItemImages = null;

	function startTest() {
		$this->ItemImages = new TestItemImages();
		$this->ItemImages->constructClasses();
	}

	function testItemImagesControllerInstance() {
		$this->assertTrue(is_a($this->ItemImages, 'ItemImagesController'));
	}

	function endTest() {
		unset($this->ItemImages);
	}
}
?>
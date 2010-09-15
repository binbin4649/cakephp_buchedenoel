<?php 
/* SVN FILE: $Id$ */
/* TagsController Test cases generated on: 2009-06-15 15:06:32 : 1245048272*/
App::import('Controller', 'Tags');

class TestTags extends TagsController {
	var $autoRender = false;
}

class TagsControllerTest extends CakeTestCase {
	var $Tags = null;

	function startTest() {
		$this->Tags = new TestTags();
		$this->Tags->constructClasses();
	}

	function testTagsControllerInstance() {
		$this->assertTrue(is_a($this->Tags, 'TagsController'));
	}

	function endTest() {
		unset($this->Tags);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Tag Test cases generated on: 2009-06-07 20:06:27 : 1244373447*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $Tag = null;
	var $fixtures = array('app.tag');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function testTagInstance() {
		$this->assertTrue(is_a($this->Tag, 'Tag'));
	}

	function testTagFind() {
		$this->Tag->recursive = -1;
		$results = $this->Tag->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Tag' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-06-07 20:17:27',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:17:27',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:17:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
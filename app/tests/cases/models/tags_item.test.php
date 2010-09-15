<?php 
/* SVN FILE: $Id$ */
/* TagsItem Test cases generated on: 2009-06-07 20:06:08 : 1244373488*/
App::import('Model', 'TagsItem');

class TagsItemTestCase extends CakeTestCase {
	var $TagsItem = null;
	var $fixtures = array('app.tags_item');

	function startTest() {
		$this->TagsItem =& ClassRegistry::init('TagsItem');
	}

	function testTagsItemInstance() {
		$this->assertTrue(is_a($this->TagsItem, 'TagsItem'));
	}

	function testTagsItemFind() {
		$this->TagsItem->recursive = -1;
		$results = $this->TagsItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TagsItem' => array(
			'id'  => 1,
			'item_id'  => 1,
			'tag_id'  => 1,
			'created'  => '2009-06-07 20:18:08',
			'created_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
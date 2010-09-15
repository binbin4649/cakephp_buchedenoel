<?php 
/* SVN FILE: $Id$ */
/* MemoCategory Test cases generated on: 2009-07-24 12:07:37 : 1248405757*/
App::import('Model', 'MemoCategory');

class MemoCategoryTestCase extends CakeTestCase {
	var $MemoCategory = null;
	var $fixtures = array('app.memo_category', 'app.memo_data');

	function startTest() {
		$this->MemoCategory =& ClassRegistry::init('MemoCategory');
	}

	function testMemoCategoryInstance() {
		$this->assertTrue(is_a($this->MemoCategory, 'MemoCategory'));
	}

	function testMemoCategoryFind() {
		$this->MemoCategory->recursive = -1;
		$results = $this->MemoCategory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MemoCategory' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'memo_sections_id'  => 1,
			'created_user'  => 1,
			'updated_user'  => 1,
			'created'  => '2009-07-24 12:22:32',
			'updated'  => '2009-07-24 12:22:32',
			'deleted'  => 1,
			'deleted_date'  => '2009-07-24 12:22:32'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* MemoData Test cases generated on: 2009-07-24 12:07:16 : 1248405976*/
App::import('Model', 'MemoData');

class MemoDataTestCase extends CakeTestCase {
	var $MemoData = null;
	var $fixtures = array('app.memo_data', 'app.memo_category');

	function startTest() {
		$this->MemoData =& ClassRegistry::init('MemoData');
	}

	function testMemoDataInstance() {
		$this->assertTrue(is_a($this->MemoData, 'MemoData'));
	}

	function testMemoDataFind() {
		$this->MemoData->recursive = -1;
		$results = $this->MemoData->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('MemoData' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'memo_category_id'  => 1,
			'top_flag'  => 1,
			'dev_status'  => 'Lorem ipsum dolor ',
			'q_status'  => 1,
			'contents'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'reply'  => 1,
			'file'  => 'Lorem ipsum dolor sit amet',
			'created_user'  => 1,
			'updated_user'  => 1,
			'created'  => '2009-07-24 12:26:15',
			'updated'  => '2009-07-24 12:26:15',
			'deleted'  => 1,
			'deleted_date'  => '2009-07-24 12:26:15'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
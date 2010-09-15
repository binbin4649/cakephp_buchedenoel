<?php 
/* SVN FILE: $Id$ */
/* Stone Test cases generated on: 2009-06-07 20:06:52 : 1244373412*/
App::import('Model', 'Stone');

class StoneTestCase extends CakeTestCase {
	var $Stone = null;
	var $fixtures = array('app.stone');

	function startTest() {
		$this->Stone =& ClassRegistry::init('Stone');
	}

	function testStoneInstance() {
		$this->assertTrue(is_a($this->Stone, 'Stone'));
	}

	function testStoneFind() {
		$this->Stone->recursive = -1;
		$results = $this->Stone->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Stone' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'notes'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-06-07 20:16:52',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:16:52',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:16:52'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Process Test cases generated on: 2009-06-07 20:06:45 : 1244373345*/
App::import('Model', 'Process');

class ProcessTestCase extends CakeTestCase {
	var $Process = null;
	var $fixtures = array('app.process');

	function startTest() {
		$this->Process =& ClassRegistry::init('Process');
	}

	function testProcessInstance() {
		$this->assertTrue(is_a($this->Process, 'Process'));
	}

	function testProcessFind() {
		$this->Process->recursive = -1;
		$results = $this->Process->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Process' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'cleaning_plan'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'notes'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-06-07 20:15:45',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:15:45',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:15:45'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
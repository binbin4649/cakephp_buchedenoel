<?php 
/* SVN FILE: $Id$ */
/* TimeCard Test cases generated on: 2009-06-05 19:06:54 : 1244198874*/
App::import('Model', 'TimeCard');

class TimeCardTestCase extends CakeTestCase {
	var $TimeCard = null;
	var $fixtures = array('app.time_card');

	function startTest() {
		$this->TimeCard =& ClassRegistry::init('TimeCard');
	}

	function testTimeCardInstance() {
		$this->assertTrue(is_a($this->TimeCard, 'TimeCard'));
	}

	function testTimeCardFind() {
		$this->TimeCard->recursive = -1;
		$results = $this->TimeCard->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TimeCard' => array(
			'id'  => 1,
			'chopping'  => 'Lorem ipsum dolor sit amet',
			'user_id'  => 1,
			'ip_cpde'  => 1,
			'remarks'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created_user'  => 1,
			'updated_user'  => 1,
			'created'  => '2009-06-05 19:47:54',
			'updated'  => '2009-06-05 19:47:54',
			'deleted'  => 1,
			'deleted_date'  => '2009-06-05 19:47:54'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
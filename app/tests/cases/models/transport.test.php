<?php 
/* SVN FILE: $Id$ */
/* Transport Test cases generated on: 2009-08-08 18:08:39 : 1249724439*/
App::import('Model', 'Transport');

class TransportTestCase extends CakeTestCase {
	var $Transport = null;
	var $fixtures = array('app.transport', 'app.transport_dateil');

	function startTest() {
		$this->Transport =& ClassRegistry::init('Transport');
	}

	function testTransportInstance() {
		$this->assertTrue(is_a($this->Transport, 'Transport'));
	}

	function testTransportFind() {
		$this->Transport->recursive = -1;
		$results = $this->Transport->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Transport' => array(
			'id'  => 1,
			'out_depot'  => 1,
			'in_depot'  => 1,
			'transport_status'  => 1,
			'delivary_date'  => '2009-08-08',
			'arrival_date'  => '2009-08-08',
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'layaway_type'  => 1,
			'layaway_user'  => 1,
			'created'  => '2009-08-08 18:40:39',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:40:39',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
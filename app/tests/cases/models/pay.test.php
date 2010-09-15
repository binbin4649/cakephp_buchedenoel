<?php 
/* SVN FILE: $Id$ */
/* Pay Test cases generated on: 2009-08-08 18:08:15 : 1249725255*/
App::import('Model', 'Pay');

class PayTestCase extends CakeTestCase {
	var $Pay = null;
	var $fixtures = array('app.pay', 'app.factory');

	function startTest() {
		$this->Pay =& ClassRegistry::init('Pay');
	}

	function testPayInstance() {
		$this->assertTrue(is_a($this->Pay, 'Pay'));
	}

	function testPayFind() {
		$this->Pay->recursive = -1;
		$results = $this->Pay->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Pay' => array(
			'id'  => 1,
			'factory_id'  => 1,
			'date'  => '2009-08-08',
			'pay_status'  => 1,
			'partner_no'  => 'Lorem ipsum dolor sit amet',
			'pay_way_type'  => 1,
			'total'  => 1,
			'tax'  => 1,
			'adjustment'  => 1,
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:54:15',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:54:15',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
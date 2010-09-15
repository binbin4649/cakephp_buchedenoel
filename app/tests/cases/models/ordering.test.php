<?php 
/* SVN FILE: $Id$ */
/* Ordering Test cases generated on: 2009-08-08 18:08:45 : 1249724685*/
App::import('Model', 'Ordering');

class OrderingTestCase extends CakeTestCase {
	var $Ordering = null;
	var $fixtures = array('app.ordering', 'app.factory', 'app.purchase_detail');

	function startTest() {
		$this->Ordering =& ClassRegistry::init('Ordering');
	}

	function testOrderingInstance() {
		$this->assertTrue(is_a($this->Ordering, 'Ordering'));
	}

	function testOrderingFind() {
		$this->Ordering->recursive = -1;
		$results = $this->Ordering->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Ordering' => array(
			'id'  => 1,
			'ordering_status'  => 1,
			'factory_id'  => 1,
			'date'  => '2009-08-08',
			'total'  => 1,
			'total_tax'  => 1,
			'adjustment'  => 1,
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:44:45',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:44:45',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
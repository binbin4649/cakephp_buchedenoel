<?php 
/* SVN FILE: $Id$ */
/* SalesStateCode Test cases generated on: 2009-06-07 20:06:27 : 1244373267*/
App::import('Model', 'SalesStateCode');

class SalesStateCodeTestCase extends CakeTestCase {
	var $SalesStateCode = null;
	var $fixtures = array('app.sales_state_code');

	function startTest() {
		$this->SalesStateCode =& ClassRegistry::init('SalesStateCode');
	}

	function testSalesStateCodeInstance() {
		$this->assertTrue(is_a($this->SalesStateCode, 'SalesStateCode'));
	}

	function testSalesStateCodeFind() {
		$this->SalesStateCode->recursive = -1;
		$results = $this->SalesStateCode->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('SalesStateCode' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'explain'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'cutom_order_approve'  => 'Lorem ipsum dolor sit amet',
			'order_approve'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-06-07 20:14:27',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:14:27',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:14:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Purchase Test cases generated on: 2009-08-08 18:08:52 : 1249724872*/
App::import('Model', 'Purchase');

class PurchaseTestCase extends CakeTestCase {
	var $Purchase = null;
	var $fixtures = array('app.purchase', 'app.factory', 'app.depot', 'app.purchase_detail');

	function startTest() {
		$this->Purchase =& ClassRegistry::init('Purchase');
	}

	function testPurchaseInstance() {
		$this->assertTrue(is_a($this->Purchase, 'Purchase'));
	}

	function testPurchaseFind() {
		$this->Purchase->recursive = -1;
		$results = $this->Purchase->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Purchase' => array(
			'id'  => 1,
			'invoices'  => 'Lorem ipsum dolor sit amet',
			'purchase_status'  => 1,
			'factory_id'  => 1,
			'date'  => '2009-08-08',
			'depot_id'  => 1,
			'total'  => 1,
			'total_tax'  => 1,
			'adjustment'  => 1,
			'shipping'  => 1,
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:47:52',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:47:52',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
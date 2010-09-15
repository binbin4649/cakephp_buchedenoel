<?php 
/* SVN FILE: $Id$ */
/* StockRevision Test cases generated on: 2009-08-08 18:08:01 : 1249724341*/
App::import('Model', 'StockRevision');

class StockRevisionTestCase extends CakeTestCase {
	var $StockRevision = null;
	var $fixtures = array('app.stock_revision');

	function startTest() {
		$this->StockRevision =& ClassRegistry::init('StockRevision');
	}

	function testStockRevisionInstance() {
		$this->assertTrue(is_a($this->StockRevision, 'StockRevision'));
	}

	function testStockRevisionFind() {
		$this->StockRevision->recursive = -1;
		$results = $this->StockRevision->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('StockRevision' => array(
			'id'  => 1,
			'subitem_id'  => 1,
			'depot_id'  => 1,
			'quantity'  => 1,
			'stock_change'  => 1,
			'reason_type'  => 1,
			'reason'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:39:01',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:39:01',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
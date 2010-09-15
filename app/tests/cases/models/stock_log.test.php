<?php 
/* SVN FILE: $Id$ */
/* StockLog Test cases generated on: 2009-08-08 18:08:52 : 1249724272*/
App::import('Model', 'StockLog');

class StockLogTestCase extends CakeTestCase {
	var $StockLog = null;
	var $fixtures = array('app.stock_log');

	function startTest() {
		$this->StockLog =& ClassRegistry::init('StockLog');
	}

	function testStockLogInstance() {
		$this->assertTrue(is_a($this->StockLog, 'StockLog'));
	}

	function testStockLogFind() {
		$this->StockLog->recursive = -1;
		$results = $this->StockLog->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('StockLog' => array(
			'id'  => 1,
			'subitem_id'  => 1,
			'depot_id'  => 1,
			'quantity'  => 1,
			'plus'  => 1,
			'mimus'  => 1,
			'created'  => '2009-08-08 18:37:52',
			'created_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
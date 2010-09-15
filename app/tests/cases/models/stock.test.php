<?php 
/* SVN FILE: $Id$ */
/* Stock Test cases generated on: 2009-08-11 21:08:06 : 1249994826*/
App::import('Model', 'Stock');

class StockTestCase extends CakeTestCase {
	var $Stock = null;
	var $fixtures = array('app.stock', 'app.subitem', 'app.depot');

	function startTest() {
		$this->Stock =& ClassRegistry::init('Stock');
	}

	function testStockInstance() {
		$this->assertTrue(is_a($this->Stock, 'Stock'));
	}

	function testStockFind() {
		$this->Stock->recursive = -1;
		$results = $this->Stock->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Stock' => array(
			'id'  => 1,
			'subitem_id'  => 1,
			'depot_id'  => 1,
			'quantity'  => 1,
			'created'  => '2009-08-11 21:47:01',
			'created_user'  => 1,
			'updated'  => '2009-08-11 21:47:01',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
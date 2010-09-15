<?php 
/* SVN FILE: $Id$ */
/* OrderingsDetail Test cases generated on: 2009-08-08 18:08:35 : 1249724795*/
App::import('Model', 'OrderingsDetail');

class OrderingsDetailTestCase extends CakeTestCase {
	var $OrderingsDetail = null;
	var $fixtures = array('app.orderings_detail', 'app.ordering', 'app.order', 'app.order_dateil', 'app.item', 'app.subitem');

	function startTest() {
		$this->OrderingsDetail =& ClassRegistry::init('OrderingsDetail');
	}

	function testOrderingsDetailInstance() {
		$this->assertTrue(is_a($this->OrderingsDetail, 'OrderingsDetail'));
	}

	function testOrderingsDetailFind() {
		$this->OrderingsDetail->recursive = -1;
		$results = $this->OrderingsDetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderingsDetail' => array(
			'id'  => 1,
			'ordering_id'  => 1,
			'order_id'  => 1,
			'order_dateil_id'  => 1,
			'item_id'  => 1,
			'subitem_id'  => 1,
			'size'  => 'Lorem ipsum dolor ',
			'depot'  => 1,
			'specified_date'  => '2009-08-08',
			'bid'  => 1,
			'temporary_bid'  => 1,
			'ordering_quantity'  => 1,
			'stock_quantity'  => 1,
			'created'  => '2009-08-08 18:46:35',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:46:35',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
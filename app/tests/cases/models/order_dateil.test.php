<?php 
/* SVN FILE: $Id$ */
/* OrderDateil Test cases generated on: 2009-08-08 19:08:05 : 1249725665*/
App::import('Model', 'OrderDateil');

class OrderDateilTestCase extends CakeTestCase {
	var $OrderDateil = null;
	var $fixtures = array('app.order_dateil', 'app.order', 'app.item', 'app.subitem', 'app.transport_dateil', 'app.orderings_detail', 'app.purchase_detail');

	function startTest() {
		$this->OrderDateil =& ClassRegistry::init('OrderDateil');
	}

	function testOrderDateilInstance() {
		$this->assertTrue(is_a($this->OrderDateil, 'OrderDateil'));
	}

	function testOrderDateilFind() {
		$this->OrderDateil->recursive = -1;
		$results = $this->OrderDateil->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrderDateil' => array(
			'id'  => 1,
			'order_id'  => 1,
			'detail_no'  => 1,
			'item_id'  => 1,
			'subitem_id'  => 1,
			'size'  => 'Lorem ipsum dolor ',
			'lot_type'  => 1,
			'specified_date'  => '2009-08-08',
			'store_arrival_date'  => '2009-08-08',
			'stock_date'  => '2009-08-08',
			'shipping_date'  => '2009-08-08',
			'bid'  => 1,
			'bid_quantity'  => 1,
			'cost'  => 1,
			'tax'  => 1,
			'pairing_quantity'  => 1,
			'ordering_quantity'  => 1,
			'sell_quantity'  => 1,
			'marking'  => 'Lorem ipsum dolor sit amet',
			'transport_dateil_id'  => 1,
			'created'  => '2009-08-08 19:01:05',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:01:05',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
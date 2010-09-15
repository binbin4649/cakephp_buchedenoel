<?php 
/* SVN FILE: $Id$ */
/* OrdersSale Test cases generated on: 2009-08-08 19:08:49 : 1249725829*/
App::import('Model', 'OrdersSale');

class OrdersSaleTestCase extends CakeTestCase {
	var $OrdersSale = null;
	var $fixtures = array('app.orders_sale');

	function startTest() {
		$this->OrdersSale =& ClassRegistry::init('OrdersSale');
	}

	function testOrdersSaleInstance() {
		$this->assertTrue(is_a($this->OrdersSale, 'OrdersSale'));
	}

	function testOrdersSaleFind() {
		$this->OrdersSale->recursive = -1;
		$results = $this->OrdersSale->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OrdersSale' => array(
			'id'  => 1,
			'order_id'  => 1,
			'sale_id'  => 1,
			'created'  => '2009-08-08 19:03:49',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:03:49',
			'updated_user'  => 1,
			'cancel_flag'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
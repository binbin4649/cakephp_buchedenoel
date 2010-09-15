<?php 
/* SVN FILE: $Id$ */
/* Order Test cases generated on: 2009-08-08 18:08:22 : 1249725502*/
App::import('Model', 'Order');

class OrderTestCase extends CakeTestCase {
	var $Order = null;
	var $fixtures = array('app.order', 'app.depot', 'app.order_dateil', 'app.orderings_detail', 'app.purchase_detail');

	function startTest() {
		$this->Order =& ClassRegistry::init('Order');
	}

	function testOrderInstance() {
		$this->assertTrue(is_a($this->Order, 'Order'));
	}

	function testOrderFind() {
		$this->Order->recursive = -1;
		$results = $this->Order->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Order' => array(
			'id'  => 1,
			'order_type'  => 1,
			'depot_id'  => 1,
			'order_status'  => 1,
			'destination_id'  => 1,
			'events_no'  => 'Lorem ip',
			'span_no'  => 'Lorem ip',
			'date'  => '2009-08-08',
			'contact1'  => 1,
			'contact2'  => 1,
			'contact3'  => 1,
			'contact4'  => 1,
			'contribute1'  => 1,
			'contribute2'  => 1,
			'contribute3'  => 1,
			'contribute4'  => 1,
			'customers_name'  => 'Lorem ipsum dolor sit amet',
			'pairing1'  => 1,
			'pairing2'  => 1,
			'pairing3'  => 1,
			'pairing4'  => 1,
			'partners_no'  => 'Lorem ipsum dolor sit amet',
			'total'  => 1,
			'price_total'  => 1,
			'total_tax'  => 1,
			'shipping'  => 1,
			'adjustment'  => 1,
			'delivery_no'  => 'Lorem ipsum dolor sit amet',
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:58:22',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:58:22',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
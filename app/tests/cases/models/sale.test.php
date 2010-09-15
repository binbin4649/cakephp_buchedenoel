<?php 
/* SVN FILE: $Id$ */
/* Sale Test cases generated on: 2009-08-08 19:08:19 : 1249726039*/
App::import('Model', 'Sale');

class SaleTestCase extends CakeTestCase {
	var $Sale = null;
	var $fixtures = array('app.sale', 'app.depot', 'app.invoice_dateil');

	function startTest() {
		$this->Sale =& ClassRegistry::init('Sale');
	}

	function testSaleInstance() {
		$this->assertTrue(is_a($this->Sale, 'Sale'));
	}

	function testSaleFind() {
		$this->Sale->recursive = -1;
		$results = $this->Sale->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sale' => array(
			'id'  => 1,
			'order_type'  => 1,
			'depot_id'  => 1,
			'destination_id'  => 1,
			'event_no'  => 'Lorem ipsum dolor ',
			'span_no'  => 'Lorem ipsum dolor ',
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
			'partners_no'  => 'Lorem ipsum dolor sit amet',
			'total'  => 1,
			'item_price_total'  => 1,
			'tax'  => 1,
			'shipping'  => 1,
			'adjustment'  => 1,
			'total_day'  => 1,
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 19:07:18',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:07:18',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
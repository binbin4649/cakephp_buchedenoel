<?php 
/* SVN FILE: $Id$ */
/* PurchaseDetail Test cases generated on: 2009-08-08 18:08:07 : 1249725007*/
App::import('Model', 'PurchaseDetail');

class PurchaseDetailTestCase extends CakeTestCase {
	var $PurchaseDetail = null;
	var $fixtures = array('app.purchase_detail', 'app.purchase', 'app.order', 'app.order_dateil', 'app.ordering', 'app.ordering_dateil', 'app.item', 'app.subitem');

	function startTest() {
		$this->PurchaseDetail =& ClassRegistry::init('PurchaseDetail');
	}

	function testPurchaseDetailInstance() {
		$this->assertTrue(is_a($this->PurchaseDetail, 'PurchaseDetail'));
	}

	function testPurchaseDetailFind() {
		$this->PurchaseDetail->recursive = -1;
		$results = $this->PurchaseDetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PurchaseDetail' => array(
			'id'  => 1,
			'purchase_id'  => 1,
			'order_id'  => 1,
			'order_dateil_id'  => 1,
			'ordering_id'  => 1,
			'ordering_dateil_id'  => 1,
			'item_id'  => 1,
			'subitem_id'  => 1,
			'size'  => 'Lorem ipsum dolor ',
			'bid'  => 1,
			'quantity'  => 1,
			'pay_quantity'  => 1,
			'gram'  => 'Lorem ',
			'created'  => '2009-08-08 18:50:07',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:50:07',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
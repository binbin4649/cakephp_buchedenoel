<?php 
/* SVN FILE: $Id$ */
/* InvoiceDateil Test cases generated on: 2009-08-08 19:08:22 : 1249727002*/
App::import('Model', 'InvoiceDateil');

class InvoiceDateilTestCase extends CakeTestCase {
	var $InvoiceDateil = null;
	var $fixtures = array('app.invoice_dateil', 'app.invoice', 'app.sale');

	function startTest() {
		$this->InvoiceDateil =& ClassRegistry::init('InvoiceDateil');
	}

	function testInvoiceDateilInstance() {
		$this->assertTrue(is_a($this->InvoiceDateil, 'InvoiceDateil'));
	}

	function testInvoiceDateilFind() {
		$this->InvoiceDateil->recursive = -1;
		$results = $this->InvoiceDateil->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('InvoiceDateil' => array(
			'id'  => 1,
			'invoice_id'  => 1,
			'detail_no'  => 1,
			'sale_id'  => 1,
			'sale_date'  => '2009-08-08',
			'sale_total'  => 1,
			'sale_items'  => 1,
			'tax'  => 1,
			'shipping'  => 1,
			'adjustment'  => 1,
			'total_quantity'  => 1,
			'created'  => '2009-08-08 19:23:22',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:23:22',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
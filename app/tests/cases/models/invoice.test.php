<?php 
/* SVN FILE: $Id$ */
/* Invoice Test cases generated on: 2009-08-08 19:08:02 : 1249726862*/
App::import('Model', 'Invoice');

class InvoiceTestCase extends CakeTestCase {
	var $Invoice = null;
	var $fixtures = array('app.invoice', 'app.section', 'app.billing', 'app.credit', 'app.credit', 'app.invoice_dateil');

	function startTest() {
		$this->Invoice =& ClassRegistry::init('Invoice');
	}

	function testInvoiceInstance() {
		$this->assertTrue(is_a($this->Invoice, 'Invoice'));
	}

	function testInvoiceFind() {
		$this->Invoice->recursive = -1;
		$results = $this->Invoice->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Invoice' => array(
			'id'  => 1,
			'section_id'  => 1,
			'billing_id'  => 1,
			'date'  => '2009-08-08',
			'previous_invoice'  => 1,
			'previous_deposit'  => 1,
			'balance_forward'  => 1,
			'sales'  => 1,
			'tax'  => 1,
			'total'  => 1,
			'month_total'  => 1,
			'created'  => '2009-08-08 19:21:02',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:21:02',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
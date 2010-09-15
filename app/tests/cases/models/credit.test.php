<?php 
/* SVN FILE: $Id$ */
/* Credit Test cases generated on: 2009-08-08 19:08:47 : 1249727267*/
App::import('Model', 'Credit');

class CreditTestCase extends CakeTestCase {
	var $Credit = null;
	var $fixtures = array('app.credit', 'app.invoice', 'app.bank_acut');

	function startTest() {
		$this->Credit =& ClassRegistry::init('Credit');
	}

	function testCreditInstance() {
		$this->assertTrue(is_a($this->Credit, 'Credit'));
	}

	function testCreditFind() {
		$this->Credit->recursive = -1;
		$results = $this->Credit->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Credit' => array(
			'id'  => 1,
			'invoice_id'  => 1,
			'date'  => '2009-08-08',
			'credit_methods'  => 1,
			'bank_acut_id'  => 1,
			'deposit_amount'  => 1,
			'transfer_fee'  => 1,
			'offset_amount'  => 1,
			'adjustment'  => 1,
			'reconcile_amount'  => 1,
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 19:27:47',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:27:47',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
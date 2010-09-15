<?php 
/* SVN FILE: $Id$ */
/* Billing Test cases generated on: 2009-08-08 17:08:18 : 1249721178*/
App::import('Model', 'Billing');

class BillingTestCase extends CakeTestCase {
	var $Billing = null;
	var $fixtures = array('app.billing', 'app.invoice');

	function startTest() {
		$this->Billing =& ClassRegistry::init('Billing');
	}

	function testBillingInstance() {
		$this->assertTrue(is_a($this->Billing, 'Billing'));
	}

	function testBillingFind() {
		$this->Billing->recursive = -1;
		$results = $this->Billing->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Billing' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'contact_section'  => 'Lorem ipsum dolor sit amet',
			'contact_post'  => 'Lorem ipsum dolor sit amet',
			'contact_name'  => 'Lorem ipsum dolor sit amet',
			'post_code'  => 'Lorem ips',
			'district'  => 1,
			'address_one'  => 'Lorem ipsum dolor sit amet',
			'address_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 'Lorem ipsum dolor sit amet',
			'fax'  => 'Lorem ipsum dolor sit amet',
			'invoice_type'  => 1,
			'total_day'  => '2009-08-08',
			'payment_day'  => '2009-08-08',
			'mail'  => 'Lorem ipsum dolor sit amet',
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 17:46:18',
			'created_user'  => 1,
			'updated'  => '2009-08-08 17:46:18',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Destination Test cases generated on: 2009-08-08 18:08:57 : 1249722957*/
App::import('Model', 'Destination');

class DestinationTestCase extends CakeTestCase {
	var $Destination = null;
	var $fixtures = array('app.destination', 'app.company', 'app.company', 'app.order', 'app.sale');

	function startTest() {
		$this->Destination =& ClassRegistry::init('Destination');
	}

	function testDestinationInstance() {
		$this->assertTrue(is_a($this->Destination, 'Destination'));
	}

	function testDestinationFind() {
		$this->Destination->recursive = -1;
		$results = $this->Destination->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Destination' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'company_id'  => 1,
			'contact_section'  => 'Lorem ipsum dolor sit amet',
			'contact_post'  => 'Lorem ipsum dolor sit amet',
			'contact_name'  => 'Lorem ipsum dolor sit amet',
			'post_code'  => 'Lorem ipsum dolor sit amet',
			'district'  => 1,
			'address_one'  => 'Lorem ipsum dolor sit amet',
			'address_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 'Lorem ipsum dolor sit amet',
			'fax'  => 'Lorem ipsum dolor sit amet',
			'shipping_flag'  => 1,
			'shipping_condition'  => 1,
			'shipping_cost'  => 1,
			'mail'  => 'Lorem ipsum dolor sit amet',
			'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-08-08 18:15:57',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:15:57',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* TransportDateil Test cases generated on: 2009-08-08 18:08:23 : 1249724543*/
App::import('Model', 'TransportDateil');

class TransportDateilTestCase extends CakeTestCase {
	var $TransportDateil = null;
	var $fixtures = array('app.transport_dateil', 'app.transport', 'app.subitem', 'app.order_dateil');

	function startTest() {
		$this->TransportDateil =& ClassRegistry::init('TransportDateil');
	}

	function testTransportDateilInstance() {
		$this->assertTrue(is_a($this->TransportDateil, 'TransportDateil'));
	}

	function testTransportDateilFind() {
		$this->TransportDateil->recursive = -1;
		$results = $this->TransportDateil->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('TransportDateil' => array(
			'id'  => 1,
			'transport_id'  => 1,
			'subitem_id'  => 1,
			'quantity'  => 1,
			'pairing_quantity'  => 1,
			'created'  => '2009-08-08 18:42:23',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:42:23',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
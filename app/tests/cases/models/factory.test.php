<?php 
/* SVN FILE: $Id$ */
/* Factory Test cases generated on: 2009-06-07 20:06:55 : 1244373055*/
App::import('Model', 'Factory');

class FactoryTestCase extends CakeTestCase {
	var $Factory = null;
	var $fixtures = array('app.factory');

	function startTest() {
		$this->Factory =& ClassRegistry::init('Factory');
	}

	function testFactoryInstance() {
		$this->assertTrue(is_a($this->Factory, 'Factory'));
	}

	function testFactoryFind() {
		$this->Factory->recursive = -1;
		$results = $this->Factory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Factory' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'name_kana'  => 'Lorem ipsum dolor sit amet',
			'charge_person'  => 'Lorem ipsum dolor sit amet',
			'charge_section'  => 'Lorem ipsum dolor sit amet',
			'post_code'  => 1,
			'districts'  => 'Lorem ipsum dolor sit amet',
			'adress_one'  => 'Lorem ipsum dolor sit amet',
			'adress_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 'Lorem ipsum dolor ',
			'extension_tel'  => 'Lorem ipsum dolor ',
			'fax'  => 'Lorem ipsum dolor ',
			'mail'  => 'Lorem ipsum dolor sit amet',
			'delivery_days'  => 1,
			'custom_order_days'  => 1,
			'repair_days'  => 1,
			'total_day'  => '2009-06-07',
			'payment_day'  => '2009-06-07',
			'payment_code'  => 'Lorem ipsum dolor ',
			'trading_flag'  => 'Lorem ipsum dolor ',
			'dm_flag'  => 'Lorem ipsum dolor ',
			'trading_start'  => '2009-06-07',
			'trading_end'  => '2009-06-07',
			'created'  => '2009-06-07 20:10:55',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:10:55',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:10:55'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
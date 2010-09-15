<?php 
/* SVN FILE: $Id$ */
/* SalesDateil Test cases generated on: 2009-08-08 19:08:35 : 1249726715*/
App::import('Model', 'SalesDateil');

class SalesDateilTestCase extends CakeTestCase {
	var $SalesDateil = null;
	var $fixtures = array('app.sales_dateil', 'app.sales', 'app.item', 'app.subitem');

	function startTest() {
		$this->SalesDateil =& ClassRegistry::init('SalesDateil');
	}

	function testSalesDateilInstance() {
		$this->assertTrue(is_a($this->SalesDateil, 'SalesDateil'));
	}

	function testSalesDateilFind() {
		$this->SalesDateil->recursive = -1;
		$results = $this->SalesDateil->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('SalesDateil' => array(
			'id'  => 1,
			'sales_id'  => 1,
			'detail_no'  => 1,
			'item_id'  => 1,
			'subitem_id'  => 1,
			'size'  => 'Lorem ipsum dolor ',
			'bid'  => 1,
			'bid_quantity'  => 1,
			'cost'  => 1,
			'tax'  => 1,
			'marking'  => 'Lorem ipsum dolor sit amet',
			'credit_quantity'  => 1,
			'created'  => '2009-08-08 19:18:35',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:18:35',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
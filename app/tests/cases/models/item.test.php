<?php 
/* SVN FILE: $Id$ */
/* Item Test cases generated on: 2009-06-07 20:06:59 : 1244373119*/
App::import('Model', 'Item');

class ItemTestCase extends CakeTestCase {
	var $Item = null;
	var $fixtures = array('app.item');

	function startTest() {
		$this->Item =& ClassRegistry::init('Item');
	}

	function testItemInstance() {
		$this->assertTrue(is_a($this->Item, 'Item'));
	}

	function testItemFind() {
		$this->Item->recursive = -1;
		$results = $this->Item->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Item' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'brand_id'  => 1,
			'factory_id'  => 1,
			'price'  => 1,
			'stock_code'  => 1,
			'sales_state_code_id'  => 1,
			'process_id'  => 1,
			'material_id'  => 1,
			'stone_id'  => 1,
			'stone_other'  => 'Lorem ipsum dolor sit amet',
			'stone_spec'  => 'Lorem ipsum dolor sit amet',
			'message_stamp'  => 'Lorem ipsum dolor sit amet',
			'message_stamp_ja'  => 'Lorem ipsum dolor sit amet',
			'release_day'  => '2009-06-07',
			'order_end_day'  => '2009-06-07',
			'demension'  => 'Lorem ipsum dolor sit amet',
			'weight'  => 1,
			'unit'  => 'Lorem ipsum dolor sit amet',
			'order_approve'  => 'Lorem ipsum dolor sit amet',
			'cutom_order_approve'  => 'Lorem ipsum dolor sit amet',
			'custom_order_days'  => 1,
			'repair_days'  => 1,
			'trans_approve'  => 'Lorem ipsum dolor sit amet',
			'in_chain'  => 'Lorem ipsum dolor sit amet',
			'atelier_trans_approve'  => 'Lorem ipsum dolor sit amet',
			'labor_cost'  => 1,
			'supply_full_cost'  => 1,
			'cost'  => 1,
			'percent_code'  => 'Lorem ipsum dolor sit amet',
			'sales_sum_code'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-06-07 20:11:59',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:11:59',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:11:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
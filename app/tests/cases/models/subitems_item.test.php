<?php 
/* SVN FILE: $Id$ */
/* SubitemsItem Test cases generated on: 2009-06-09 18:06:21 : 1244541381*/
App::import('Model', 'SubitemsItem');

class SubitemsItemTestCase extends CakeTestCase {
	var $SubitemsItem = null;
	var $fixtures = array('app.subitems_item');

	function startTest() {
		$this->SubitemsItem =& ClassRegistry::init('SubitemsItem');
	}

	function testSubitemsItemInstance() {
		$this->assertTrue(is_a($this->SubitemsItem, 'SubitemsItem'));
	}

	function testSubitemsItemFind() {
		$this->SubitemsItem->recursive = -1;
		$results = $this->SubitemsItem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('SubitemsItem' => array(
			'id'  => 1,
			'subitem_id'  => 1,
			'item_id'  => 1,
			'quantity'  => 1,
			'supply_code_id'  => 1,
			'created'  => '2009-06-09 18:56:21',
			'created_user'  => 1,
			'updated'  => '2009-06-09 18:56:21',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-09 18:56:21'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
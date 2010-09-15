<?php 
/* SVN FILE: $Id$ */
/* Inventory Test cases generated on: 2009-08-08 18:08:31 : 1249724191*/
App::import('Model', 'Inventory');

class InventoryTestCase extends CakeTestCase {
	var $Inventory = null;
	var $fixtures = array('app.inventory');

	function startTest() {
		$this->Inventory =& ClassRegistry::init('Inventory');
	}

	function testInventoryInstance() {
		$this->assertTrue(is_a($this->Inventory, 'Inventory'));
	}

	function testInventoryFind() {
		$this->Inventory->recursive = -1;
		$results = $this->Inventory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Inventory' => array(
			'id'  => 1,
			'subitem_id'  => 1,
			'depot_id'  => 1,
			'quantity'  => 1,
			'created'  => '2009-08-08 18:36:31',
			'created_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
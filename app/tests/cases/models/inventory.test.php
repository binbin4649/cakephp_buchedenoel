<?php 
/* SVN FILE: $Id$ */
/* Inventory Test cases generated on: 2010-11-02 16:11:16 : 1288684096*/
App::import('Model', 'Inventory');

class InventoryTestCase extends CakeTestCase {
	var $Inventory = null;
	var $fixtures = array('app.inventory', 'app.section', 'app.inventory_detail');

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
			'section_id'  => 1,
			'status'  => 1,
			'print_file'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2010-11-02 16:48:03',
			'created_user'  => 1,
			'updated'  => '2010-11-02 16:48:03',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
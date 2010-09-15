<?php 
/* SVN FILE: $Id$ */
/* Subitem Test cases generated on: 2009-06-07 20:06:39 : 1244373159*/
App::import('Model', 'Subitem');

class SubitemTestCase extends CakeTestCase {
	var $Subitem = null;
	var $fixtures = array('app.subitem');

	function startTest() {
		$this->Subitem =& ClassRegistry::init('Subitem');
	}

	function testSubitemInstance() {
		$this->assertTrue(is_a($this->Subitem, 'Subitem'));
	}

	function testSubitemFind() {
		$this->Subitem->recursive = -1;
		$results = $this->Subitem->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Subitem' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'item_id'  => 1,
			'jan'  => 1,
			'name_kana'  => 'Lorem ipsum dolor sit amet',
			'labor_cost'  => 1,
			'supply_full_cost'  => 1,
			'cost'  => 1,
			'created'  => '2009-06-07 20:12:39',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:12:39',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:12:39'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
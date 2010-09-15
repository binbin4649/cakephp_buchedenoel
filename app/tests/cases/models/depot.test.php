<?php 
/* SVN FILE: $Id$ */
/* Depot Test cases generated on: 2009-08-08 18:08:17 : 1249723937*/
App::import('Model', 'Depot');

class DepotTestCase extends CakeTestCase {
	var $Depot = null;
	var $fixtures = array('app.depot', 'app.section', 'app.order', 'app.purchase', 'app.sale', 'app.stock');

	function startTest() {
		$this->Depot =& ClassRegistry::init('Depot');
	}

	function testDepotInstance() {
		$this->assertTrue(is_a($this->Depot, 'Depot'));
	}

	function testDepotFind() {
		$this->Depot->recursive = -1;
		$results = $this->Depot->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Depot' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'section_id'  => 1,
			'default'  => 1,
			'created'  => '2009-08-08 18:32:17',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:32:17',
			'updated_user'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Part Test cases generated on: 2009-06-12 16:06:37 : 1244792137*/
App::import('Model', 'Part');

class PartTestCase extends CakeTestCase {
	var $Part = null;
	var $fixtures = array('app.part');

	function startTest() {
		$this->Part =& ClassRegistry::init('Part');
	}

	function testPartInstance() {
		$this->assertTrue(is_a($this->Part, 'Part'));
	}

	function testPartFind() {
		$this->Part->recursive = -1;
		$results = $this->Part->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Part' => array(
			'id'  => 1,
			'item_id'  => 1,
			'subitem_id'  => 1,
			'quantity'  => 1,
			'supply_code'  => 1,
			'created'  => '2009-06-12 16:34:58',
			'updated'  => '2009-06-12 16:34:58'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
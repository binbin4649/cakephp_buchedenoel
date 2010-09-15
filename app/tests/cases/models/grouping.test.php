<?php 
/* SVN FILE: $Id$ */
/* Grouping Test cases generated on: 2009-08-08 18:08:58 : 1249723138*/
App::import('Model', 'Grouping');

class GroupingTestCase extends CakeTestCase {
	var $Grouping = null;
	var $fixtures = array('app.grouping');

	function startTest() {
		$this->Grouping =& ClassRegistry::init('Grouping');
	}

	function testGroupingInstance() {
		$this->assertTrue(is_a($this->Grouping, 'Grouping'));
	}

	function testGroupingFind() {
		$this->Grouping->recursive = -1;
		$results = $this->Grouping->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Grouping' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-08-08 18:18:58',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:18:58',
			'updated_user'  => 1,
			'cancel_flag'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
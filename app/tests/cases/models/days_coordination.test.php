<?php 
/* SVN FILE: $Id$ */
/* DaysCoordination Test cases generated on: 2009-06-07 20:06:02 : 1244373302*/
App::import('Model', 'DaysCoordination');

class DaysCoordinationTestCase extends CakeTestCase {
	var $DaysCoordination = null;
	var $fixtures = array('app.days_coordination');

	function startTest() {
		$this->DaysCoordination =& ClassRegistry::init('DaysCoordination');
	}

	function testDaysCoordinationInstance() {
		$this->assertTrue(is_a($this->DaysCoordination, 'DaysCoordination'));
	}

	function testDaysCoordinationFind() {
		$this->DaysCoordination->recursive = -1;
		$results = $this->DaysCoordination->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('DaysCoordination' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'apply_approve'  => 'Lorem ipsum dolor sit amet',
			'coordination_approve'  => 'Lorem ipsum dolor sit amet',
			'start_datetime'  => 'Lorem ipsum dolor sit amet',
			'end_datetime'  => 'Lorem ipsum dolor sit amet',
			'apply_day'  => 1,
			'created'  => '2009-06-07 20:15:02',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:15:02',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:15:02'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
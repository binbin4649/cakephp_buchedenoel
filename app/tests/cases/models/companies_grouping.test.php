<?php 
/* SVN FILE: $Id$ */
/* CompaniesGrouping Test cases generated on: 2009-08-08 19:08:57 : 1249725777*/
App::import('Model', 'CompaniesGrouping');

class CompaniesGroupingTestCase extends CakeTestCase {
	var $CompaniesGrouping = null;
	var $fixtures = array('app.companies_grouping');

	function startTest() {
		$this->CompaniesGrouping =& ClassRegistry::init('CompaniesGrouping');
	}

	function testCompaniesGroupingInstance() {
		$this->assertTrue(is_a($this->CompaniesGrouping, 'CompaniesGrouping'));
	}

	function testCompaniesGroupingFind() {
		$this->CompaniesGrouping->recursive = -1;
		$results = $this->CompaniesGrouping->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('CompaniesGrouping' => array(
			'id'  => 1,
			'company_id'  => 1,
			'grouping_id'  => 1,
			'created'  => '2009-08-08 19:02:57',
			'created_user'  => 1,
			'updated'  => '2009-08-08 19:02:57',
			'updated_user'  => 1,
			'cancel_flag'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
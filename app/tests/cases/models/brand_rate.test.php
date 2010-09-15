<?php 
/* SVN FILE: $Id$ */
/* BrandRate Test cases generated on: 2009-08-08 18:08:04 : 1249722784*/
App::import('Model', 'BrandRate');

class BrandRateTestCase extends CakeTestCase {
	var $BrandRate = null;
	var $fixtures = array('app.brand_rate', 'app.company', 'app.brand');

	function startTest() {
		$this->BrandRate =& ClassRegistry::init('BrandRate');
	}

	function testBrandRateInstance() {
		$this->assertTrue(is_a($this->BrandRate, 'BrandRate'));
	}

	function testBrandRateFind() {
		$this->BrandRate->recursive = -1;
		$results = $this->BrandRate->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('BrandRate' => array(
			'id'  => 1,
			'company_id'  => 1,
			'brand_id'  => 1,
			'rate'  => 1,
			'created'  => '2009-08-08 18:13:04',
			'created_user'  => 1,
			'updated'  => '2009-08-08 18:13:04',
			'updated_user'  => 1,
			'cancel_flag'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Brand Test cases generated on: 2009-06-07 20:06:50 : 1244373530*/
App::import('Model', 'Brand');

class BrandTestCase extends CakeTestCase {
	var $Brand = null;
	var $fixtures = array('app.brand');

	function startTest() {
		$this->Brand =& ClassRegistry::init('Brand');
	}

	function testBrandInstance() {
		$this->assertTrue(is_a($this->Brand, 'Brand'));
	}

	function testBrandFind() {
		$this->Brand->recursive = -1;
		$results = $this->Brand->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Brand' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'temporary_costrate'  => 1,
			'created'  => '2009-06-07 20:18:50',
			'created_user'  => 1,
			'updated'  => '2009-06-07 20:18:50',
			'updated_user'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-06-07 20:18:50'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
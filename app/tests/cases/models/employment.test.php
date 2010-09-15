<?php 
/* SVN FILE: $Id$ */
/* Employment Test cases generated on: 2009-06-04 17:06:22 : 1244102962*/
App::import('Model', 'Employment');

class EmploymentTestCase extends CakeTestCase {
	var $Employment = null;
	var $fixtures = array('app.employment');

	function startTest() {
		$this->Employment =& ClassRegistry::init('Employment');
	}

	function testEmploymentInstance() {
		$this->assertTrue(is_a($this->Employment, 'Employment'));
	}

	function testEmploymentFind() {
		$this->Employment->recursive = -1;
		$results = $this->Employment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Employment' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'delete_flag'  => 1,
			'kyuuyo_bugyo_code'  => 1,
			'name_english'  => 'Lorem ipsum dolor sit amet',
			'list_order'  => 1,
			'created_user'  => 1,
			'updated_user'  => 1,
			'created'  => '2009-06-04 17:09:22',
			'updated'  => '2009-06-04 17:09:22'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
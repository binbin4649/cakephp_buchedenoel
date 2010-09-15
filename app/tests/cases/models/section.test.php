<?php 
/* SVN FILE: $Id$ */
/* Section Test cases generated on: 2009-06-04 17:06:17 : 1244103077*/
App::import('Model', 'Section');

class SectionTestCase extends CakeTestCase {
	var $Section = null;
	var $fixtures = array('app.section');

	function startTest() {
		$this->Section =& ClassRegistry::init('Section');
	}

	function testSectionInstance() {
		$this->assertTrue(is_a($this->Section, 'Section'));
	}

	function testSectionFind() {
		$this->Section->recursive = -1;
		$results = $this->Section->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Section' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'delete_flag'  => 1,
			'kyuuyo_bugyo_highrank_code'  => 1,
			'kyuuyo_bugyo_code'  => 1,
			'kanjo_bugyo_code'  => 1,
			'name_english'  => 'Lorem ipsum dolor sit amet',
			'sales_code'  => 'Lorem ipsum do',
			'tax_method'  => 'Lorem ipsum dolor sit amet',
			'tax_fraction'  => 'Lorem ipsum dolor sit amet',
			'auto_share_priority'  => 'Lorem ipsum dolor sit amet',
			'post_code'  => 1,
			'districts'  => 'Lorem ipsum dolor sit amet',
			'adress_one'  => 'Lorem ipsum dolor sit amet',
			'adress_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 1,
			'mail'  => 'Lorem ipsum dolor sit amet',
			'ip_number'  => 1,
			'created_user'  => 1,
			'updated_user'  => 1,
			'password'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-06-04 17:11:17',
			'updated'  => '2009-06-04 17:11:17'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2009-06-04 11:06:06 : 1244083326*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'delete'  => 1,
			'kyuuyo_bugyo_code'  => 1,
			'section_id'  => 1,
			'post_id'  => 1,
			'employment_id'  => 1,
			'name_kana'  => 'Lorem ipsum dolor sit amet',
			'name_english'  => 'Lorem ipsum dolor sit amet',
			'sex'  => 'Lorem ',
			'post_code'  => 1,
			'districts'  => 'Lorem ipsum dolor sit amet',
			'adress_one'  => 'Lorem ipsum dolor sit amet',
			'adress_two'  => 'Lorem ipsum dolor sit amet',
			'tel'  => 1,
			'mail'  => 'Lorem ipsum dolor sit amet',
			'birth_day'  => '2009-06-04',
			'blood_type'  => 'Lorem ipsum do',
			'duty_code'  => 'Lorem ipsum do',
			'join_day'  => '2009-06-04',
			'exit_day'  => '2009-06-04',
			'created_user'  => 1,
			'updated_user'  => 1,
			'password'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-06-04 11:42:06',
			'updated'  => '2009-06-04 11:42:06'
		));
		$this->assertEqual($results, $expected);
	}
}
?>
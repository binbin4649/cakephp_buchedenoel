<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-06-04 11:06:06 : 1244083326*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'delete' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'kyuuyo_bugyo_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 40),
		'section_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'post_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'employment_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'name_kana' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'name_english' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'sex' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 8),
		'post_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'districts' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'adress_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'adress_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'mail' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'birth_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'blood_type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 16),
		'duty_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 16),
		'join_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'exit_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>
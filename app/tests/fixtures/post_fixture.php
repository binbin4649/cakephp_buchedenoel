<?php 
/* SVN FILE: $Id$ */
/* Post Fixture generated on: 2009-06-04 17:06:40 : 1244103040*/

class PostFixture extends CakeTestFixture {
	var $name = 'Post';
	var $table = 'posts';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'delete_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'kyuuyo_bugyo_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'name_english' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'list_order' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 40),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'delete_flag'  => 1,
		'kyuuyo_bugyo_code'  => 1,
		'name_english'  => 'Lorem ipsum dolor sit amet',
		'list_order'  => 1,
		'created_user'  => 1,
		'updated_user'  => 1,
		'created'  => '2009-06-04 17:10:40',
		'updated'  => '2009-06-04 17:10:40'
	));
}
?>
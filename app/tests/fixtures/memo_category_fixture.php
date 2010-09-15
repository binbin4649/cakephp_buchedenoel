<?php 
/* SVN FILE: $Id$ */
/* MemoCategory Fixture generated on: 2009-07-24 12:07:32 : 1248405752*/

class MemoCategoryFixture extends CakeTestFixture {
	var $name = 'MemoCategory';
	var $table = 'memo_categories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'memo_sections_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'memo_sections_id'  => 1,
		'created_user'  => 1,
		'updated_user'  => 1,
		'created'  => '2009-07-24 12:22:32',
		'updated'  => '2009-07-24 12:22:32',
		'deleted'  => 1,
		'deleted_date'  => '2009-07-24 12:22:32'
	));
}
?>
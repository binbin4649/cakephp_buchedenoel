<?php 
/* SVN FILE: $Id$ */
/* Pair Fixture generated on: 2009-06-07 20:06:05 : 1244373605*/

class PairFixture extends CakeTestFixture {
	var $name = 'Pair';
	var $table = 'pairs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'ladys_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'mens_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'updated' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'deleted' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'deleted_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'ladys_id'  => 1,
		'mens_id'  => 1,
		'created'  => '2009-06-07 20:20:05',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:20:05',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:20:05'
	));
}
?>
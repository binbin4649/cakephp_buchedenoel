<?php 
/* SVN FILE: $Id$ */
/* Grouping Fixture generated on: 2009-08-08 18:08:58 : 1249723138*/

class GroupingFixture extends CakeTestFixture {
	var $name = 'Grouping';
	var $table = 'groupings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'cancel_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-08-08 18:18:58',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:18:58',
		'updated_user'  => 1,
		'cancel_flag'  => 1
	));
}
?>
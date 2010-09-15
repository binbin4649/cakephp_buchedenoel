<?php 
/* SVN FILE: $Id$ */
/* Depot Fixture generated on: 2009-08-08 18:08:17 : 1249723937*/

class DepotFixture extends CakeTestFixture {
	var $name = 'Depot';
	var $table = 'depots';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
		'section_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'default' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'section_id'  => 1,
		'default'  => 1,
		'created'  => '2009-08-08 18:32:17',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:32:17',
		'updated_user'  => 1
	));
}
?>
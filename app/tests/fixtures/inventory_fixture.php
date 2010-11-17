<?php 
/* SVN FILE: $Id$ */
/* Inventory Fixture generated on: 2010-11-02 16:11:03 : 1288684083*/

class InventoryFixture extends CakeTestFixture {
	var $name = 'Inventory';
	var $table = 'inventories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'section_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 1),
		'print_file' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'section_id'  => 1,
		'status'  => 1,
		'print_file'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2010-11-02 16:48:03',
		'created_user'  => 1,
		'updated'  => '2010-11-02 16:48:03',
		'updated_user'  => 1
	));
}
?>
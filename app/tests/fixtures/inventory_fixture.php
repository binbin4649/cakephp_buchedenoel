<?php 
/* SVN FILE: $Id$ */
/* Inventory Fixture generated on: 2009-08-08 18:08:31 : 1249724191*/

class InventoryFixture extends CakeTestFixture {
	var $name = 'Inventory';
	var $table = 'inventories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'subitem_id'  => 1,
		'depot_id'  => 1,
		'quantity'  => 1,
		'created'  => '2009-08-08 18:36:31',
		'created_user'  => 1
	));
}
?>
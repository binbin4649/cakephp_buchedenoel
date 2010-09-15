<?php 
/* SVN FILE: $Id$ */
/* SubitemsItem Fixture generated on: 2009-06-09 18:06:21 : 1244541381*/

class SubitemsItemFixture extends CakeTestFixture {
	var $name = 'SubitemsItem';
	var $table = 'subitems_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'supply_code_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
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
		'subitem_id'  => 1,
		'item_id'  => 1,
		'quantity'  => 1,
		'supply_code_id'  => 1,
		'created'  => '2009-06-09 18:56:21',
		'created_user'  => 1,
		'updated'  => '2009-06-09 18:56:21',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-09 18:56:21'
	));
}
?>
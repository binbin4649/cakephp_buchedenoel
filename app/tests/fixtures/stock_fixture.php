<?php 
/* SVN FILE: $Id$ */
/* Stock Fixture generated on: 2009-08-11 21:08:01 : 1249994821*/

class StockFixture extends CakeTestFixture {
	var $name = 'Stock';
	var $table = 'stocks';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'subitem_id'  => 1,
		'depot_id'  => 1,
		'quantity'  => 1,
		'created'  => '2009-08-11 21:47:01',
		'created_user'  => 1,
		'updated'  => '2009-08-11 21:47:01',
		'updated_user'  => 1
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* Part Fixture generated on: 2009-06-12 16:06:58 : 1244792098*/

class PartFixture extends CakeTestFixture {
	var $name = 'Part';
	var $table = 'parts';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'supply_code' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'item_id'  => 1,
		'subitem_id'  => 1,
		'quantity'  => 1,
		'supply_code'  => 1,
		'created'  => '2009-06-12 16:34:58',
		'updated'  => '2009-06-12 16:34:58'
	));
}
?>
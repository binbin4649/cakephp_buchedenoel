<?php 
/* SVN FILE: $Id$ */
/* StockLog Fixture generated on: 2009-08-08 18:08:52 : 1249724272*/

class StockLogFixture extends CakeTestFixture {
	var $name = 'StockLog';
	var $table = 'stock_logs';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'plus' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'mimus' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'subitem_id'  => 1,
		'depot_id'  => 1,
		'quantity'  => 1,
		'plus'  => 1,
		'mimus'  => 1,
		'created'  => '2009-08-08 18:37:52',
		'created_user'  => 1
	));
}
?>
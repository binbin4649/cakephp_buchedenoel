<?php 
/* SVN FILE: $Id$ */
/* OrderingsDetail Fixture generated on: 2009-08-08 18:08:35 : 1249724795*/

class OrderingsDetailFixture extends CakeTestFixture {
	var $name = 'OrderingsDetail';
	var $table = 'orderings_details';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'ordering_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'order_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'order_dateil_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'size' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'depot' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'specified_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'bid' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'temporary_bid' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'ordering_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'stock_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'ordering_id'  => 1,
		'order_id'  => 1,
		'order_dateil_id'  => 1,
		'item_id'  => 1,
		'subitem_id'  => 1,
		'size'  => 'Lorem ipsum dolor ',
		'depot'  => 1,
		'specified_date'  => '2009-08-08',
		'bid'  => 1,
		'temporary_bid'  => 1,
		'ordering_quantity'  => 1,
		'stock_quantity'  => 1,
		'created'  => '2009-08-08 18:46:35',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:46:35',
		'updated_user'  => 1
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* OrderDateil Fixture generated on: 2009-08-08 19:08:05 : 1249725665*/

class OrderDateilFixture extends CakeTestFixture {
	var $name = 'OrderDateil';
	var $table = 'order_dateils';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'detail_no' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'size' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'lot_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'specified_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'store_arrival_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'stock_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'shipping_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'bid' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'bid_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'cost' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'pairing_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'ordering_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'sell_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'marking' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'transport_dateil_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'order_id'  => 1,
		'detail_no'  => 1,
		'item_id'  => 1,
		'subitem_id'  => 1,
		'size'  => 'Lorem ipsum dolor ',
		'lot_type'  => 1,
		'specified_date'  => '2009-08-08',
		'store_arrival_date'  => '2009-08-08',
		'stock_date'  => '2009-08-08',
		'shipping_date'  => '2009-08-08',
		'bid'  => 1,
		'bid_quantity'  => 1,
		'cost'  => 1,
		'tax'  => 1,
		'pairing_quantity'  => 1,
		'ordering_quantity'  => 1,
		'sell_quantity'  => 1,
		'marking'  => 'Lorem ipsum dolor sit amet',
		'transport_dateil_id'  => 1,
		'created'  => '2009-08-08 19:01:05',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:01:05',
		'updated_user'  => 1
	));
}
?>
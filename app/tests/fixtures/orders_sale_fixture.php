<?php 
/* SVN FILE: $Id$ */
/* OrdersSale Fixture generated on: 2009-08-08 19:08:49 : 1249725829*/

class OrdersSaleFixture extends CakeTestFixture {
	var $name = 'OrdersSale';
	var $table = 'orders_sales';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'order_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'sale_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'cancel_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'order_id'  => 1,
		'sale_id'  => 1,
		'created'  => '2009-08-08 19:03:49',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:03:49',
		'updated_user'  => 1,
		'cancel_flag'  => 1
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* SalesDateil Fixture generated on: 2009-08-08 19:08:35 : 1249726715*/

class SalesDateilFixture extends CakeTestFixture {
	var $name = 'SalesDateil';
	var $table = 'sales_dateils';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'sales_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'detail_no' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'size' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'bid' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'bid_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'cost' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'marking' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'credit_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'sales_id'  => 1,
		'detail_no'  => 1,
		'item_id'  => 1,
		'subitem_id'  => 1,
		'size'  => 'Lorem ipsum dolor ',
		'bid'  => 1,
		'bid_quantity'  => 1,
		'cost'  => 1,
		'tax'  => 1,
		'marking'  => 'Lorem ipsum dolor sit amet',
		'credit_quantity'  => 1,
		'created'  => '2009-08-08 19:18:35',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:18:35',
		'updated_user'  => 1
	));
}
?>
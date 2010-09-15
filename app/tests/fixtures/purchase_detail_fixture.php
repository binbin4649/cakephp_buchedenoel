<?php 
/* SVN FILE: $Id$ */
/* PurchaseDetail Fixture generated on: 2009-08-08 18:08:07 : 1249725007*/

class PurchaseDetailFixture extends CakeTestFixture {
	var $name = 'PurchaseDetail';
	var $table = 'purchase_details';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'purchase_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'order_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'order_dateil_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'ordering_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'ordering_dateil_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'size' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'bid' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'pay_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'gram' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'purchase_id'  => 1,
		'order_id'  => 1,
		'order_dateil_id'  => 1,
		'ordering_id'  => 1,
		'ordering_dateil_id'  => 1,
		'item_id'  => 1,
		'subitem_id'  => 1,
		'size'  => 'Lorem ipsum dolor ',
		'bid'  => 1,
		'quantity'  => 1,
		'pay_quantity'  => 1,
		'gram'  => 'Lorem ',
		'created'  => '2009-08-08 18:50:07',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:50:07',
		'updated_user'  => 1
	));
}
?>
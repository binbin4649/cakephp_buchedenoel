<?php 
/* SVN FILE: $Id$ */
/* InvoiceDateil Fixture generated on: 2009-08-08 19:08:22 : 1249727002*/

class InvoiceDateilFixture extends CakeTestFixture {
	var $name = 'InvoiceDateil';
	var $table = 'invoice_dateils';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'detail_no' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'sale_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'sale_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'sale_total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'sale_items' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'shipping' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'total_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'invoice_id'  => 1,
		'detail_no'  => 1,
		'sale_id'  => 1,
		'sale_date'  => '2009-08-08',
		'sale_total'  => 1,
		'sale_items'  => 1,
		'tax'  => 1,
		'shipping'  => 1,
		'adjustment'  => 1,
		'total_quantity'  => 1,
		'created'  => '2009-08-08 19:23:22',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:23:22',
		'updated_user'  => 1
	));
}
?>
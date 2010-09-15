<?php 
/* SVN FILE: $Id$ */
/* Invoice Fixture generated on: 2009-08-08 19:08:02 : 1249726862*/

class InvoiceFixture extends CakeTestFixture {
	var $name = 'Invoice';
	var $table = 'invoices';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'section_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'billing_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'previous_invoice' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'previous_deposit' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'balance_forward' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'sales' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'month_total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'section_id'  => 1,
		'billing_id'  => 1,
		'date'  => '2009-08-08',
		'previous_invoice'  => 1,
		'previous_deposit'  => 1,
		'balance_forward'  => 1,
		'sales'  => 1,
		'tax'  => 1,
		'total'  => 1,
		'month_total'  => 1,
		'created'  => '2009-08-08 19:21:02',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:21:02',
		'updated_user'  => 1
	));
}
?>
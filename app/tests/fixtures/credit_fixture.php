<?php 
/* SVN FILE: $Id$ */
/* Credit Fixture generated on: 2009-08-08 19:08:47 : 1249727267*/

class CreditFixture extends CakeTestFixture {
	var $name = 'Credit';
	var $table = 'credits';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'invoice_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'credit_methods' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'bank_acut_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'deposit_amount' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'transfer_fee' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'offset_amount' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'reconcile_amount' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'invoice_id'  => 1,
		'date'  => '2009-08-08',
		'credit_methods'  => 1,
		'bank_acut_id'  => 1,
		'deposit_amount'  => 1,
		'transfer_fee'  => 1,
		'offset_amount'  => 1,
		'adjustment'  => 1,
		'reconcile_amount'  => 1,
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 19:27:47',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:27:47',
		'updated_user'  => 1
	));
}
?>
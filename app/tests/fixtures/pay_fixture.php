<?php 
/* SVN FILE: $Id$ */
/* Pay Fixture generated on: 2009-08-08 18:08:15 : 1249725255*/

class PayFixture extends CakeTestFixture {
	var $name = 'Pay';
	var $table = 'pays';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'factory_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'pay_status' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'partner_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'pay_way_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'factory_id'  => 1,
		'date'  => '2009-08-08',
		'pay_status'  => 1,
		'partner_no'  => 'Lorem ipsum dolor sit amet',
		'pay_way_type'  => 1,
		'total'  => 1,
		'tax'  => 1,
		'adjustment'  => 1,
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 18:54:15',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:54:15',
		'updated_user'  => 1
	));
}
?>
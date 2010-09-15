<?php 
/* SVN FILE: $Id$ */
/* Billing Fixture generated on: 2009-08-08 17:08:18 : 1249721178*/

class BillingFixture extends CakeTestFixture {
	var $name = 'Billing';
	var $table = 'billings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'contact_section' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'contact_post' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'contact_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'post_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 11),
		'district' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'address_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'address_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'fax' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'invoice_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'total_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'payment_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'mail' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'contact_section'  => 'Lorem ipsum dolor sit amet',
		'contact_post'  => 'Lorem ipsum dolor sit amet',
		'contact_name'  => 'Lorem ipsum dolor sit amet',
		'post_code'  => 'Lorem ips',
		'district'  => 1,
		'address_one'  => 'Lorem ipsum dolor sit amet',
		'address_two'  => 'Lorem ipsum dolor sit amet',
		'tel'  => 'Lorem ipsum dolor sit amet',
		'fax'  => 'Lorem ipsum dolor sit amet',
		'invoice_type'  => 1,
		'total_day'  => '2009-08-08',
		'payment_day'  => '2009-08-08',
		'mail'  => 'Lorem ipsum dolor sit amet',
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 17:46:18',
		'created_user'  => 1,
		'updated'  => '2009-08-08 17:46:18',
		'updated_user'  => 1
	));
}
?>
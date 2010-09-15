<?php 
/* SVN FILE: $Id$ */
/* Destination Fixture generated on: 2009-08-08 18:08:57 : 1249722957*/

class DestinationFixture extends CakeTestFixture {
	var $name = 'Destination';
	var $table = 'destinations';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
		'company_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'contact_section' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'contact_post' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'contact_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 60),
		'post_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'district' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'address_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'address_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'fax' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'shipping_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'shipping_condition' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'shipping_cost' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
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
		'company_id'  => 1,
		'contact_section'  => 'Lorem ipsum dolor sit amet',
		'contact_post'  => 'Lorem ipsum dolor sit amet',
		'contact_name'  => 'Lorem ipsum dolor sit amet',
		'post_code'  => 'Lorem ipsum dolor sit amet',
		'district'  => 1,
		'address_one'  => 'Lorem ipsum dolor sit amet',
		'address_two'  => 'Lorem ipsum dolor sit amet',
		'tel'  => 'Lorem ipsum dolor sit amet',
		'fax'  => 'Lorem ipsum dolor sit amet',
		'shipping_flag'  => 1,
		'shipping_condition'  => 1,
		'shipping_cost'  => 1,
		'mail'  => 'Lorem ipsum dolor sit amet',
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 18:15:57',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:15:57',
		'updated_user'  => 1
	));
}
?>
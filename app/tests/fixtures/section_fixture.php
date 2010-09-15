<?php 
/* SVN FILE: $Id$ */
/* Section Fixture generated on: 2009-06-04 17:06:17 : 1244103077*/

class SectionFixture extends CakeTestFixture {
	var $name = 'Section';
	var $table = 'sections';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'delete_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'kyuuyo_bugyo_highrank_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 40),
		'kyuuyo_bugyo_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 40),
		'kanjo_bugyo_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 40),
		'name_english' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'sales_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 16),
		'tax_method' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'tax_fraction' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'auto_share_priority' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 32),
		'post_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'districts' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'adress_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'adress_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'mail' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'ip_number' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 16),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'delete_flag'  => 1,
		'kyuuyo_bugyo_highrank_code'  => 1,
		'kyuuyo_bugyo_code'  => 1,
		'kanjo_bugyo_code'  => 1,
		'name_english'  => 'Lorem ipsum dolor sit amet',
		'sales_code'  => 'Lorem ipsum do',
		'tax_method'  => 'Lorem ipsum dolor sit amet',
		'tax_fraction'  => 'Lorem ipsum dolor sit amet',
		'auto_share_priority'  => 'Lorem ipsum dolor sit amet',
		'post_code'  => 1,
		'districts'  => 'Lorem ipsum dolor sit amet',
		'adress_one'  => 'Lorem ipsum dolor sit amet',
		'adress_two'  => 'Lorem ipsum dolor sit amet',
		'tel'  => 1,
		'mail'  => 'Lorem ipsum dolor sit amet',
		'ip_number'  => 1,
		'created_user'  => 1,
		'updated_user'  => 1,
		'password'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-06-04 17:11:17',
		'updated'  => '2009-06-04 17:11:17'
	));
}
?>
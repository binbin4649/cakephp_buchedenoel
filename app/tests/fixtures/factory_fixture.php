<?php 
/* SVN FILE: $Id$ */
/* Factory Fixture generated on: 2009-06-07 20:06:55 : 1244373055*/

class FactoryFixture extends CakeTestFixture {
	var $name = 'Factory';
	var $table = 'factories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'name_kana' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'charge_person' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'charge_section' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'post_code' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'districts' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'adress_one' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'adress_two' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'tel' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'extension_tel' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'fax' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'mail' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'delivery_days' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'custom_order_days' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'repair_days' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'total_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'payment_day' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'payment_code' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'trading_flag' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'dm_flag' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'trading_start' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'trading_end' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'updated' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'deleted' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'deleted_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'name_kana'  => 'Lorem ipsum dolor sit amet',
		'charge_person'  => 'Lorem ipsum dolor sit amet',
		'charge_section'  => 'Lorem ipsum dolor sit amet',
		'post_code'  => 1,
		'districts'  => 'Lorem ipsum dolor sit amet',
		'adress_one'  => 'Lorem ipsum dolor sit amet',
		'adress_two'  => 'Lorem ipsum dolor sit amet',
		'tel'  => 'Lorem ipsum dolor ',
		'extension_tel'  => 'Lorem ipsum dolor ',
		'fax'  => 'Lorem ipsum dolor ',
		'mail'  => 'Lorem ipsum dolor sit amet',
		'delivery_days'  => 1,
		'custom_order_days'  => 1,
		'repair_days'  => 1,
		'total_day'  => '2009-06-07',
		'payment_day'  => '2009-06-07',
		'payment_code'  => 'Lorem ipsum dolor ',
		'trading_flag'  => 'Lorem ipsum dolor ',
		'dm_flag'  => 'Lorem ipsum dolor ',
		'trading_start'  => '2009-06-07',
		'trading_end'  => '2009-06-07',
		'created'  => '2009-06-07 20:10:55',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:10:55',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:10:55'
	));
}
?>
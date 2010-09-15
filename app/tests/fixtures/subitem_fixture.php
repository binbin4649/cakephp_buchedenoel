<?php 
/* SVN FILE: $Id$ */
/* Subitem Fixture generated on: 2009-06-07 20:06:39 : 1244373159*/

class SubitemFixture extends CakeTestFixture {
	var $name = 'Subitem';
	var $table = 'subitems';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'jan' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 13),
		'name_kana' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'labor_cost' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'supply_full_cost' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'cost' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
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
		'item_id'  => 1,
		'jan'  => 1,
		'name_kana'  => 'Lorem ipsum dolor sit amet',
		'labor_cost'  => 1,
		'supply_full_cost'  => 1,
		'cost'  => 1,
		'created'  => '2009-06-07 20:12:39',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:12:39',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:12:39'
	));
}
?>
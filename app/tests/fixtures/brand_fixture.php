<?php 
/* SVN FILE: $Id$ */
/* Brand Fixture generated on: 2009-06-07 20:06:50 : 1244373530*/

class BrandFixture extends CakeTestFixture {
	var $name = 'Brand';
	var $table = 'brands';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'temporary_costrate' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
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
		'temporary_costrate'  => 1,
		'created'  => '2009-06-07 20:18:50',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:18:50',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:18:50'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* BrandRate Fixture generated on: 2009-08-08 18:08:04 : 1249722784*/

class BrandRateFixture extends CakeTestFixture {
	var $name = 'BrandRate';
	var $table = 'brand_rates';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'company_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'brand_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'rate' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'cancel_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'company_id'  => 1,
		'brand_id'  => 1,
		'rate'  => 1,
		'created'  => '2009-08-08 18:13:04',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:13:04',
		'updated_user'  => 1,
		'cancel_flag'  => 1
	));
}
?>
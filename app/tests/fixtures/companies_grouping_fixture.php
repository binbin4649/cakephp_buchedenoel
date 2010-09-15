<?php 
/* SVN FILE: $Id$ */
/* CompaniesGrouping Fixture generated on: 2009-08-08 19:08:57 : 1249725777*/

class CompaniesGroupingFixture extends CakeTestFixture {
	var $name = 'CompaniesGrouping';
	var $table = 'companies_groupings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'company_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'grouping_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
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
		'grouping_id'  => 1,
		'created'  => '2009-08-08 19:02:57',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:02:57',
		'updated_user'  => 1,
		'cancel_flag'  => 1
	));
}
?>
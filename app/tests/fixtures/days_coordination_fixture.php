<?php 
/* SVN FILE: $Id$ */
/* DaysCoordination Fixture generated on: 2009-06-07 20:06:02 : 1244373302*/

class DaysCoordinationFixture extends CakeTestFixture {
	var $name = 'DaysCoordination';
	var $table = 'days_coordinations';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'apply_approve' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'coordination_approve' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'start_datetime' => array('type'=>'timestamp', 'null' => true, 'default' => NULL),
		'end_datetime' => array('type'=>'timestamp', 'null' => true, 'default' => NULL),
		'apply_day' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
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
		'apply_approve'  => 'Lorem ipsum dolor sit amet',
		'coordination_approve'  => 'Lorem ipsum dolor sit amet',
		'start_datetime'  => 'Lorem ipsum dolor sit amet',
		'end_datetime'  => 'Lorem ipsum dolor sit amet',
		'apply_day'  => 1,
		'created'  => '2009-06-07 20:15:02',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:15:02',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:15:02'
	));
}
?>
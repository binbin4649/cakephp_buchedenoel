<?php 
/* SVN FILE: $Id$ */
/* Ordering Fixture generated on: 2009-08-08 18:08:45 : 1249724685*/

class OrderingFixture extends CakeTestFixture {
	var $name = 'Ordering';
	var $table = 'orderings';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'ordering_status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'factory_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'total' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'total_tax' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'ordering_status'  => 1,
		'factory_id'  => 1,
		'date'  => '2009-08-08',
		'total'  => 1,
		'total_tax'  => 1,
		'adjustment'  => 1,
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 18:44:45',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:44:45',
		'updated_user'  => 1
	));
}
?>
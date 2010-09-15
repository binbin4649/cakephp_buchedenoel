<?php 
/* SVN FILE: $Id$ */
/* SalesStateCode Fixture generated on: 2009-06-07 20:06:27 : 1244373267*/

class SalesStateCodeFixture extends CakeTestFixture {
	var $name = 'SalesStateCode';
	var $table = 'sales_state_codes';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'explain' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'cutom_order_approve' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'order_approve' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
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
		'explain'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'cutom_order_approve'  => 'Lorem ipsum dolor sit amet',
		'order_approve'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-06-07 20:14:27',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:14:27',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:14:27'
	));
}
?>
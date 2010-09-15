<?php 
/* SVN FILE: $Id$ */
/* Process Fixture generated on: 2009-06-07 20:06:45 : 1244373345*/

class ProcessFixture extends CakeTestFixture {
	var $name = 'Process';
	var $table = 'processes';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'cleaning_plan' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'notes' => array('type'=>'text', 'null' => true, 'default' => NULL),
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
		'cleaning_plan'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'notes'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-06-07 20:15:45',
		'created_user'  => 1,
		'updated'  => '2009-06-07 20:15:45',
		'updated_user'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-06-07 20:15:45'
	));
}
?>
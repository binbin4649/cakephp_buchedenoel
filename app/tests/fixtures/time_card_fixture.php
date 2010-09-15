<?php 
/* SVN FILE: $Id$ */
/* TimeCard Fixture generated on: 2009-06-05 19:06:54 : 1244198874*/

class TimeCardFixture extends CakeTestFixture {
	var $name = 'TimeCard';
	var $table = 'time_cards';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'chopping' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'ip_cpde' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'remarks' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'deleted_date' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'chopping'  => 'Lorem ipsum dolor sit amet',
		'user_id'  => 1,
		'ip_cpde'  => 1,
		'remarks'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created_user'  => 1,
		'updated_user'  => 1,
		'created'  => '2009-06-05 19:47:54',
		'updated'  => '2009-06-05 19:47:54',
		'deleted'  => 1,
		'deleted_date'  => '2009-06-05 19:47:54'
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* MemoData Fixture generated on: 2009-07-24 12:07:15 : 1248405975*/

class MemoDataFixture extends CakeTestFixture {
	var $name = 'MemoData';
	var $table = 'memo_datas';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'memo_category_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'top_flag' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 3),
		'dev_status' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'q_status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 3),
		'contents' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'reply' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'file' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'integer', 'null' => true, 'default' => '0', 'length' => 4),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'memo_category_id'  => 1,
		'top_flag'  => 1,
		'dev_status'  => 'Lorem ipsum dolor ',
		'q_status'  => 1,
		'contents'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'reply'  => 1,
		'file'  => 'Lorem ipsum dolor sit amet',
		'created_user'  => 1,
		'updated_user'  => 1,
		'created'  => '2009-07-24 12:26:15',
		'updated'  => '2009-07-24 12:26:15',
		'deleted'  => 1,
		'deleted_date'  => '2009-07-24 12:26:15'
	));
}
?>
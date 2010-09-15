<?php 
/* SVN FILE: $Id$ */
/* Transport Fixture generated on: 2009-08-08 18:08:39 : 1249724439*/

class TransportFixture extends CakeTestFixture {
	var $name = 'Transport';
	var $table = 'transports';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'out_depot' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'in_depot' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'transport_status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'delivary_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'arrival_date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'layaway_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'layaway_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'out_depot'  => 1,
		'in_depot'  => 1,
		'transport_status'  => 1,
		'delivary_date'  => '2009-08-08',
		'arrival_date'  => '2009-08-08',
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'layaway_type'  => 1,
		'layaway_user'  => 1,
		'created'  => '2009-08-08 18:40:39',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:40:39',
		'updated_user'  => 1
	));
}
?>
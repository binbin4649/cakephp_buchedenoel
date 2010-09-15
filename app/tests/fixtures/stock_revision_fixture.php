<?php 
/* SVN FILE: $Id$ */
/* StockRevision Fixture generated on: 2009-08-08 18:08:01 : 1249724341*/

class StockRevisionFixture extends CakeTestFixture {
	var $name = 'StockRevision';
	var $table = 'stock_revisions';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'stock_change' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 6),
		'reason_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'reason' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'subitem_id'  => 1,
		'depot_id'  => 1,
		'quantity'  => 1,
		'stock_change'  => 1,
		'reason_type'  => 1,
		'reason'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 18:39:01',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:39:01',
		'updated_user'  => 1
	));
}
?>
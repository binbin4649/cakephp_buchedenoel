<?php 
/* SVN FILE: $Id$ */
/* Sale Fixture generated on: 2009-08-08 19:08:18 : 1249726038*/

class SaleFixture extends CakeTestFixture {
	var $name = 'Sale';
	var $table = 'sales';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'order_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'destination_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'event_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'span_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'contact1' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact2' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact3' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact4' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contribute1' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'contribute2' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'contribute3' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'contribute4' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'customers_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'partners_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'item_price_total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'shipping' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'total_day' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'remark' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'order_type'  => 1,
		'depot_id'  => 1,
		'destination_id'  => 1,
		'event_no'  => 'Lorem ipsum dolor ',
		'span_no'  => 'Lorem ipsum dolor ',
		'date'  => '2009-08-08',
		'contact1'  => 1,
		'contact2'  => 1,
		'contact3'  => 1,
		'contact4'  => 1,
		'contribute1'  => 1,
		'contribute2'  => 1,
		'contribute3'  => 1,
		'contribute4'  => 1,
		'customers_name'  => 'Lorem ipsum dolor sit amet',
		'partners_no'  => 'Lorem ipsum dolor sit amet',
		'total'  => 1,
		'item_price_total'  => 1,
		'tax'  => 1,
		'shipping'  => 1,
		'adjustment'  => 1,
		'total_day'  => 1,
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 19:07:18',
		'created_user'  => 1,
		'updated'  => '2009-08-08 19:07:18',
		'updated_user'  => 1
	));
}
?>
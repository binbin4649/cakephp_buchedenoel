<?php 
/* SVN FILE: $Id$ */
/* Order Fixture generated on: 2009-08-08 18:08:22 : 1249725502*/

class OrderFixture extends CakeTestFixture {
	var $name = 'Order';
	var $table = 'orders';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'order_type' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'depot_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'order_status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 6),
		'destination_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'events_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'span_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 10),
		'date' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'contact1' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact2' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact3' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contact4' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'contribute1' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'contribute2' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'contribute3' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'contribute4' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'customers_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
		'pairing1' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'pairing2' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'pairing3' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'pairing4' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'partners_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'price_total' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'total_tax' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'shipping' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'adjustment' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'delivery_no' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 40),
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
		'order_status'  => 1,
		'destination_id'  => 1,
		'events_no'  => 'Lorem ip',
		'span_no'  => 'Lorem ip',
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
		'pairing1'  => 1,
		'pairing2'  => 1,
		'pairing3'  => 1,
		'pairing4'  => 1,
		'partners_no'  => 'Lorem ipsum dolor sit amet',
		'total'  => 1,
		'price_total'  => 1,
		'total_tax'  => 1,
		'shipping'  => 1,
		'adjustment'  => 1,
		'delivery_no'  => 'Lorem ipsum dolor sit amet',
		'remark'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-08-08 18:58:22',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:58:22',
		'updated_user'  => 1
	));
}
?>
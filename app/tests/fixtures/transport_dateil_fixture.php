<?php 
/* SVN FILE: $Id$ */
/* TransportDateil Fixture generated on: 2009-08-08 18:08:23 : 1249724543*/

class TransportDateilFixture extends CakeTestFixture {
	var $name = 'TransportDateil';
	var $table = 'transport_dateils';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'transport_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'subitem_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'pairing_quantity' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 8),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated_user' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'transport_id'  => 1,
		'subitem_id'  => 1,
		'quantity'  => 1,
		'pairing_quantity'  => 1,
		'created'  => '2009-08-08 18:42:23',
		'created_user'  => 1,
		'updated'  => '2009-08-08 18:42:23',
		'updated_user'  => 1
	));
}
?>
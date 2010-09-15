<?php 
/* SVN FILE: $Id$ */
/* ItemImage Fixture generated on: 2009-06-07 20:06:53 : 1244373233*/

class ItemImageFixture extends CakeTestFixture {
	var $name = 'ItemImage';
	var $table = 'item_images';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'item_id'  => 1,
		'created'  => '2009-06-07 20:13:53',
		'created_user'  => 1
	));
}
?>
<?php 
/* SVN FILE: $Id$ */
/* TagsItem Fixture generated on: 2009-06-07 20:06:08 : 1244373488*/

class TagsItemFixture extends CakeTestFixture {
	var $name = 'TagsItem';
	var $table = 'tags_items';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary'),
		'item_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'tag_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'created_user' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'item_id'  => 1,
		'tag_id'  => 1,
		'created'  => '2009-06-07 20:18:08',
		'created_user'  => 1
	));
}
?>
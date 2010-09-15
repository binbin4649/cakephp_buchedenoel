<?php
class Tag extends AppModel {

	var $name = 'Tag';
	
	var $hasAndBelongsToMany = array('Item'=>array(
		'className'=>'Item',
		'joinTable'=>'tags_items',
		'foreignKey'=>'tag_id',
		'associationForeignKey'=>'item_id',
		'conditions'=>'',
		'order'=>'',
		'limit'=>'',
		'unique'=>true,
	));
}
?>
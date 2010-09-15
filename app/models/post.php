<?php
class Post extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'Post';
	var $hasMany = array('User'=> array('className'=>'User'));
	
}
?>
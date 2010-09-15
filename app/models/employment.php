<?php
class Employment extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'Employment';
	var $hasMany = array('User'=> array('className'=>'User'));
}
?>
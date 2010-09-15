<?php
class SalesStateCode extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'SalesStateCode';
	var $hasMany = array('Item'=> array('className'=>'Item'));

}
?>
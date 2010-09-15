<?php
class TimeCard extends AppModel {
	
	var $actsAs = array('SoftDeletable');
	var $name = 'TimeCard';
	var $belongsTo = array(
		'User'=>array('className'=>'User'),
	);

}
?>
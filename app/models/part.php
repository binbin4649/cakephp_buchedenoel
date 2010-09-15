<?php
class Part extends AppModel {

	var $name = 'Part';
	var $belongsTo = array(
		'Subitem'=> array('className'=>'Subitem'),
	);
}
?>
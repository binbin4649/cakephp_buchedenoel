<?php

$scaffold_delete_field = array(
	'delete_flag'
);

function scaffoldDeleteField($scaffoldFields){
	$scaffold_delete_field = array(
		'delete_flag',
		'kyuuyo_bugyo_code',
		'name_kana',
		'sex',
		'post_code',
		'districts',
		'adress_one',
		'adress_two',
		'tel',
		'mail',
		'birth_day',
		'blood_type',
		'duty_code',
		'list_order',
		'join_day',
		'exit_day',
		'created_user',
		'updated_user',
		'password',
		'kyuuyo_bugyo_highrank_code',
		'kyuuyo_bugyo_code',
		'kanjo_bugyo_code',
		'sales_code',
		'tax_method',
		'tax_fraction',
		'auto_share_priority',
		'ip_number',
		'deleted',
		'deleted_date',
		'remarks'
	);
	foreach($scaffoldFields as $field){
		if(!in_array($field,$scaffold_delete_field)){
			$out[] = $field;
		} 
	}
	return $out;
}






?>
<?php
class User extends AppModel {

	var $actsAs = array('SoftDeletable');
	var $name = 'User';
	var $belongsTo = array('Section'=>array('className'=>'Section'),
		'Post'=>array('className'=>'Post'),
		'Employment'=>array('className'=>'Employment')

	);
	var $hasMany = array('TimeCard'=> array('className'=>'TimeCard'));

	var $validate = array(
		'name' => VALID_NOT_EMPTY,
		'username'=>array('rule'=>'isUnique')
	);
	

	//_nameに名前を入れて返す
	function userName($user_id){
		if(!empty($user_id)){
			$params = array(
				'conditions'=>array('User.id'=>$user_id),
				'recursive'=>-1,
				'fields'=>array('User.name')
			);
			$user = $this->find('first' ,$params);
			if($user){
				return $user['User']['name'];
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	//ユーザーが無かったら空にして返す
	function cleener($user_id){
		if(!empty($user_id)){
			$params = array(
				'conditions'=>array('User.id'=>$user_id),
				'recursive'=>-1,
				'fields'=>array('User.name')
			);
			$user = $this->find('first' ,$params);
			if($user){
				return $user_id;
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
}
?>
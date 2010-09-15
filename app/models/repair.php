<?php
class Repair extends AppModel {

	var $name = 'Repair';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Factory' => array(
			'className' => 'Factory',
			'foreignKey' => 'factory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	/*
	function afterFind($results){
		foreach($results as $key=>$value){
			if(!empty($value['Repair'])){

			}
		}
		return $results;
	}
	*/
	
	function find() {
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}

	function beforeSave(){
		if(!empty($this->data['Repair']['section_id'])){
			$this->data['Repair']['section_id'] = mb_convert_kana($this->data['Repair']['section_id'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['user_id'])){
			$this->data['Repair']['user_id'] = mb_convert_kana($this->data['Repair']['user_id'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['item_id'])){
			$this->data['Repair']['item_id'] = mb_convert_kana($this->data['Repair']['item_id'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['size'])){
			$this->data['Repair']['size'] = mb_convert_kana($this->data['Repair']['size'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['factory_id'])){
			$this->data['Repair']['factory_id'] = mb_convert_kana($this->data['Repair']['factory_id'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['control_number'])){
			$this->data['Repair']['control_number'] = mb_convert_kana($this->data['Repair']['control_number'], 'a', 'UTF-8');
		}
		if(!empty($this->data['Repair']['reapir_cost'])){
			$this->data['Repair']['reapir_cost'] = mb_convert_kana($this->data['Repair']['reapir_cost'], 'a', 'UTF-8');
			$this->data['Repair']['reapir_cost'] = ereg_replace("[^0-9]", "", $this->data['Repair']['reapir_cost']);//半角数字以外を削除
		}
		if(!empty($this->data['Repair']['repair_price'])){
			$this->data['Repair']['repair_price'] = mb_convert_kana($this->data['Repair']['repair_price'], 'a', 'UTF-8');
			$this->data['Repair']['repair_price'] = ereg_replace("[^0-9]", "", $this->data['Repair']['repair_price']);//半角数字以外を削除
		}
		return true;
	}

}
?>
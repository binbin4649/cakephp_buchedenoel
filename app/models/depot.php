<?php
class Depot extends AppModel {

	var $name = 'Depot';
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Section' => array(
			'className' => 'Section',
			'foreignKey' => 'section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Sale' => array(
			'className' => 'Sale',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Stock' => array(
			'className' => 'Stock',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'OrderingsDetail' => array(
			'className' => 'OrderingsDetail',
			'foreignKey' => 'depot',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PurchaseDetail' => array(
			'className' => 'PurchaseDetail',
			'foreignKey' => 'depot',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	//Depot_idを送ると部門名と倉庫名を合体させて帰してくれる
	function sectionMarge($id){
		
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		App::import('Model', 'Section');
    	$SectionModel = new Section();
    	App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
    	$params = array(
			'conditions'=>array('Depot.id'=>$id),
			'recursive'=>0
		);
		$depot = $this->find('first' ,$params);
		$return['depot_name'] = $CleaningComponent->sectionName($depot['Depot']['name']);
		$return['depot_id'] = $depot['Depot']['id'];
		$return['section_id'] = $depot['Depot']['section_id'];
		$params = array(
			'conditions'=>array('Section.id'=>$return['section_id']),
			'recursive'=>0
		);
		$section = $this->Section->find('first' ,$params);
    	$return['section_name'] = $CleaningComponent->sectionName($section['Section']['name']);
    	return $return;
	}

	//$depot_idを送ると、倉庫名を帰してくれる
	function getName($id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		if(!empty($id)){
			$params = array(
				'conditions'=>array('Depot.id'=>$id),
				'recursive'=>0
			);
			$Depot = $this->find('first' ,$params);
			if($Depot){
				return $Depot['Depot']['name'];
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
	
	// section_id を受け取って、倉庫名：倉庫番号の形式のリストを返す、
	function sectionDepots($section_id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		$params = array(
			'conditions'=>array('Depot.section_id'=>$section_id),
			'recursive'=>0
		);
		$depots = $this->find('list' ,$params);
		foreach($depots as $id=>$name){
			$name = mb_substr($name, 0, 6);
			$depots[$id] = $name.':'.$id;
		}
		return $depots;
	}





}
?>
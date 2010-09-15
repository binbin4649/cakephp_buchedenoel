<?php
class Section extends AppModel {

	var $actsAs = array('SoftDeletable');
	var $name = 'Section';
	var $hasMany = array(
		'Depot'=> array('className'=>'Depot'),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'section_id',
			'dependent' => false,
			'conditions' => array('User.duty_code <>'=>'30'),
			'fields' => '',
			'order' => array('User.list_order'=>'asc'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
	/*
	function find() {
		
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);
		}
		$parent = get_parent_class($this);
		return call_user_func_array(array($parent, __FUNCTION__), $args);
	}
	*/
	
	// section_id を受け取ってクリーニングした名前を返す
	function cleaningName($id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array('Section.id'=>$id),
			'recursive'=>0,
			'fields'=>'Section.name'
		);
		$section = $this->find('first', $params);
		$section_name = $CleaningComponent->sectionName($section['Section']['name']);
		return $section_name;
	}
	
	//倉庫の在庫数を計算して帰す
	function viewFind($id){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		App::import('Model', 'Stock');
    	$StockModel = new Stock();
		$params = array('conditions'=>array('Section.id'=>$id));
		$section = $this->find('first', $params);
		foreach($section['Depot'] as $key=>$value){
			$section['Depot'][$key]['stock_total'] = $StockModel->DepotTotal($value['id']);
		}
		return $section;
	}

	//消費税計算方法、端数計算方法を名称に置き換える
	function view_read($fields, $id){
		$params = array('conditions'=>array('Section.id'=>$id));
		$section = $this->find('first', $params);
		$sales_code = get_sales_code();
		$tax_method = get_tax_method();
		$tax_fraction = get_tax_fraction();
		$district = get_district();
		if(!empty($section['Section']['sales_code']))$section['Section']['sales_code'] = $sales_code[$section['Section']['sales_code']];
		if(!empty($section['Section']['tax_method']))$section['Section']['tax_method'] = $tax_method[$section['Section']['tax_method']];
		if(!empty($section['Section']['tax_fraction']))$section['Section']['tax_fraction'] = $tax_fraction[$section['Section']['tax_fraction']];
		if(!empty($section['Section']['district']))$section['Section']['district'] = $district[$section['Section']['district']];

		return $section;
	}

	//名称をクリーニングし、閉鎖部門を除いたlistを返す。
	function cleaningList(){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY, __FUNCTION__, $args);//
		}
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
   		$out = array();
		$params = array(
			'conditions'=>array('Section.sales_code <>'=>4),
			'recursive'=>0,
			'fields'=>'Section.name'
		);
		$sections = $this->find('all', $params);
		foreach($sections as $section){
			$section['Section']['name'] = $CleaningComponent->sectionName($section['Section']['name']);
			$out[$section['Section']['id']] = mb_substr($section['Section']['name'], 0, 14);
		}
		return $out;
	}
	
	//集計対象の部門一覧を返す
	function amountSectionList(){
		//とりあえず、直営店だけ、ついでに部門コード順
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array('Section.sales_code'=>1),
			'recursive'=>0,
			//'order'=>array('Section.kanjo_bugyo_code DESC')
		);
		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 8);
		}
		return $sections;
	}
	
	
}
?>
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
	
	// section_id を指定するとdefault_depot_idを返す
	function defaultDepotId($section_id){
		$params = array(
			'conditions'=>array('Section.id'=>$section_id),
			'recursive'=>1,
			//'fields'=>array('Section.default_depot'),
		);
		$this->contain('Depot');
		$section = $this->find('first', $params);
		if($section){
			if(empty($section['Section']['default_depot'])){
				if(empty($section['Depot'][0]['id'])){//無かったら1番最初のやつを返す
					return false;
				}else{
					return $section['Depot'][0]['id'];
				}
			}else{
				return $section['Section']['default_depot'];
			}
		}else{
			return false;
		}
	}
	
	// そのsection_id の下に、そのdepot_idがあるのか？調べてくれる。trueだったら名前を返す
	function relationConfirm($section_id, $depot_id){
		$params = array(
			'conditions'=>array('Section.id'=>$section_id),
			'recursive'=>0,
		);
		$section = $this->find('first', $params);
		pr($section);
		exit;
		foreach($section['depot'] as $depot){
			
		}
	}
	
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
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY_RANKING, __FUNCTION__, $args);//
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
	
	// default_depot のリスト
	function defaultList(){
		if ($this->Behaviors->attached('Cache')) {
			$args = func_get_args();
			if($this->cacheEnabled()) return $this->cacheMethod(CACHE_TODAY_RANKING, __FUNCTION__, $args);//
		}
		$ins = $this->cleaningList();
		$out = array();
		foreach($ins as $id=>$name){
			$params = array(
				'conditions'=>array('Section.id'=>$id),
				'recursive'=>-1,
				'fields'=>'Section.default_depot'
			);
			$section = $this->find('first', $params);
			$out[$id]['default_depot'] = $section['Section']['default_depot'];
			$out[$id]['name'] = $name;
		}
		return $out;
	}
	
	//営業部門（店舗）のみ、新店のみを返す
	function amountSectionList5(){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
   		$params = array(
			'conditions'=>array(
				'AND'=>array('Section.sales_code'=>1, 'Section.start_date >'=>NEW_SHOP_FLAG)
				),
			'recursive'=>-1,
		);
   		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
   		return $sections;
	}
	
	//営業部門（店舗）のみ、海外店のみを返す
	//とりあえず面倒だからid直接指定する。
	function amountSectionList6(){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
   		$shop_list = get_overseashop_list();
   		$params = array(
			'conditions'=>array('id'=>$shop_list),
			'recursive'=>-1,
		);
   		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
   		return $sections;
   	}
	
	//本当は下記のようにしようと思ったけど面倒なので、1or4全部。売上が無ければ加算されないでしょ？ っていう考え方。
	//全店のlistを返す、sales_code が 1 or 4 で、営業終了日が2年以内のsection。対象から外す場合は2年以前の前の日付で登録する。
	function amountSectionList4(){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array(
				'Section.sales_code'=>array('1','4'),
				//'Section.close_date >'=>date("Y-m-d",strtotime("-2 year"))
				),
			'recursive'=>0,
			'order'=>array('Section.kanjo_bugyo_code DESC')
		);
		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
		return $sections;
	}
	
	
	//既存店のみのlistを返す、ここ1年以内にオープンした店を除外する
	function amountSectionList3(){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array(
				'AND'=>array('Section.sales_code'=>1),
				'NOT'=>array('Section.start_date >'=>date("Y-m-d",strtotime("-1 year"))),
				),
			'recursive'=>0,
		);
		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
		return $sections;
	}
	
	//集計対象の部門一覧を返す
	//とりあえず、直営店だけ、ついでに部門コード順 、新店と海外店も除外する 20110526
	function amountSectionList(){
		$shop_list = get_overseashop_list();
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array(
				'AND'=>array('Section.sales_code'=>1),
				'NOT'=>array('Section.id'=>$shop_list, 'Section.start_date >'=>NEW_SHOP_FLAG),
				),
			'recursive'=>0,
			//'order'=>array('Section.kanjo_bugyo_code DESC')
		);
		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
		return $sections;
	}
	
	//閉鎖部門以外、ついでに部門コード順
	function amountSectionList2(){
		App::import('Component', 'Cleaning');
   		$CleaningComponent = new CleaningComponent();
		$params = array(
			'conditions'=>array('Section.sales_code <>'=>4), //4=CloseCector 以外
			'recursive'=>0,
			//'order'=>array('Section.kanjo_bugyo_code DESC')
		);
		$sections = $this->find('list', $params);
		foreach($sections as $id=>$name){
			$name = $CleaningComponent->sectionName($name);
			$sections[$id] = mb_substr($name, 0, 20);
		}
		return $sections;
	}
	
}
?>
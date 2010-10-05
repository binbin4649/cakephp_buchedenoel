<?php
class Order extends AppModel {

	var $name = 'Order';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Destination' => array(
			'className' => 'Destination',
			'foreignKey' => 'destination_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

	var $hasMany = array(
		'OrderDateil' => array(
			'className' => 'OrderDateil',
			'foreignKey' => 'order_id',
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
			'foreignKey' => 'order_id',
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
			'foreignKey' => 'order_id',
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

	var $hasAndBelongsToMany = array(
		'Sale' => array(
			'className' => 'Sale',
			'joinTable' => 'orders_sales',
			'foreignKey' => 'order_id',
			'associationForeignKey' => 'sale_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
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
	
	function searchOne($id){
		App::import('Model', 'User');
    	$UserModel = new User();
    	App::import('Model', 'Depot');
    	$DepotModel = new Depot();
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
		$params = array(
			'conditions'=>array('Order.id'=>$id),
			'recursive'=>1
		);
		$order = $this->find('first' ,$params);
		$params = array(
			'conditions'=>array('User.id'=>$order['Order']['contact1']),
			'recursive'=>0
		);
		$contact1 = $UserModel->find('first' ,$params);
		$order['Order']['contact1_name'] = $contact1['User']['name'];
		if(!empty($order['Order']['contact2'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact2']),
				'recursive'=>0
			);
			$contact2 = $UserModel->find('first' ,$params);
			$order['Order']['contact2_name'] = $contact2['User']['name'];
		}else{
			$order['Order']['contact2_name'] = '';
		}
		if(!empty($order['Order']['contact3'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact3']),
				'recursive'=>0
			);
			$contact3 = $UserModel->find('first' ,$params);
			$order['Order']['contact3_name'] = $contact3['User']['name'];
		}else{
			$order['Order']['contact3_name'] = '';
		}
		if(!empty($order['Order']['contact4'])){
			$params = array(
				'conditions'=>array('User.id'=>$order['Order']['contact4']),
				'recursive'=>0
			);
			$contact4 = $UserModel->find('first' ,$params);
			$order['Order']['contact4_name'] = $contact4['User']['name'];
		}else{
			$order['Order']['contact4_name'] = '';
		}
		if(!empty($order['Order']['depot_id'])){
			$params = array(
				'conditions'=>array('Depot.id'=>$order['Order']['depot_id']),
				'recursive'=>0
			);
			$depot = $DepotModel->find('first' ,$params);
			$order['Depot']['section_name'] = $depot['Section']['name'];
		}else{
			$order['Depot']['section_name'] = '';
		}
		foreach($order['OrderDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>0
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$order['OrderDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
			$order['OrderDateil'][$key]['cost'] = $SelectorComponent->costSelector($subitem['Subitem']['item_id'], $subitem['Subitem']['cost']);
		}
		foreach($order['OrderingsDetail'] as $key=>$value){
			$order['OrderingsDetail'][$key]['created_after'] = substr($value['created'], 5, 5);
			$order['OrderingsDetail'][$key]['subitem_name'] = $SubitemModel->subitemName($value['subitem_id']);
		}
		foreach($order['PurchaseDetail'] as $key=>$value){
			$order['PurchaseDetail'][$key]['created_after'] = substr($value['created'], 5, 5);
			$order['PurchaseDetail'][$key]['subitem_name'] = $SubitemModel->subitemName($value['subitem_id']);
			$order['PurchaseDetail'][$key]['depot_name'] = $DepotModel->getName($value['depot']);
		}
		return $order;
	}

	function finish_juge($id){
		$params = array(
			'conditions'=>array('Order.id'=>$id),
			'recursive'=>1
		);
		$this->unbindModel(array('hasAndBelongsToMany'=>array('Sale')));
		$this->unbindModel(array('belongsTo'=>array('Depot')));
		$this->unbindModel(array('hasMany'=>array('OrderingsDetail', 'PurchaseDetail')));
		$order = $this->find('first' ,$params);
		$juge = True;
		if($order['Order']['order_status'] != '6'){
			foreach($order['OrderDateil'] as $key=>$value){
				if(($value['bid_quantity'] - $value['an_quantity']) <= $value['sell_quantity']){
				}else{
					$juge = false;
				}
			}
			if($juge){
				$order['Order']['order_status'] = 4;
				$this->save($order);
			}
		}
	}

	function beforeSave(){
		if(!empty($this->data['Order']['adjustment'])){
			$this->data['Order']['adjustment'] = mb_convert_kana($this->data['Order']['adjustment'], 'a', 'UTF-8');
			$this->data['Order']['adjustment'] = ereg_replace("[^0-9\-]", "", $this->data['Order']['adjustment']);//半角数字とハイフン以外削除
		}
		if(!empty($this->data['Order']['shipping'])){
			$this->data['Order']['shipping'] = mb_convert_kana($this->data['Order']['shipping'], 'a', 'UTF-8');
			$this->data['Order']['shipping'] = ereg_replace("[^0-9]", "", $this->data['Order']['shipping']);//半角数字以外を削除
		}
		if(!empty($this->data['Order']['prev_money'])){
			$this->data['Order']['prev_money'] = mb_convert_kana($this->data['Order']['prev_money'], 'a', 'UTF-8');
			$this->data['Order']['prev_money'] = ereg_replace("[^0-9]", "", $this->data['Order']['prev_money']);//半角数字以外を削除
		}
		if(!empty($this->data['Order']['price_total'])){
			$this->data['Order']['total'] = $this->data['Order']['price_total'] + $this->data['Order']['total_tax'] + $this->data['Order']['shipping'] + $this->data['Order']['adjustment'];
		}
		return true;
	}

	//合計金額と消費税の再計算。 order_id　を元に
	function orderRecalculation($order_id){
		App::import('Component', 'Total');
   		$TotalComponent = new TotalComponent();
   		App::import('Model', 'OrderDateil');
    	$OrderDateilModel = new OrderDateil();
		$params = array(
			'conditions'=>array('Order.id'=>$order_id),
			'recursive'=>1
		);
		$this->unbindModel(array('hasAndBelongsToMany'=>array('Sale')));
		$this->unbindModel(array('hasMany'=>array('OrderingsDetail', 'PurchaseDetail')));
		$order = $this->find('first' ,$params);
		$tax_method = '';
		$tax_fraction = '';
		// 取引先（出荷先）　または、　部門から消費税の計算区分を取得して反映させる。
		if(!empty($order['Destination']['company_id'])){
			App::import('Model', 'Company');
    		$CompanyModel = new Company();
    		$params = array(
				'conditions'=>array('Company.id'=>$order['Destination']['company_id']),
				'recursive'=>0
			);
			$company = $CompanyModel->find('first' ,$params);
			$tax_method = $company['Company']['tax_method'];
			$tax_fraction = $company['Company']['tax_fraction'];
		}elseif(!empty($order['Depot']['section_id'])){
			App::import('Model', 'Section');
    		$SectionModel = new Section();
    		$params = array(
				'conditions'=>array('Section.id'=>$order['Depot']['section_id']),
				'recursive'=>0
			);
			$section = $SectionModel->find('first' ,$params);
			$tax_method = $section['Section']['tax_method'];
			$tax_fraction = $section['Section']['tax_fraction'];
		}
		$sub_total = array();
		$i = 0;
		foreach($order['OrderDateil'] as $value){
			$sub_total[$i]['money'] = $value['bid'];
			$sub_total[$i]['quantity'] = $value['bid_quantity'];
			$i++;
		}
		$slip_total = $TotalComponent->slipTotal($sub_total, $tax_method, $tax_fraction);
		$order['Order']['total'] = $slip_total['total'];
		$order['Order']['price_total'] = $slip_total['detail_total'];
		$order['Order']['total_tax'] = $slip_total['tax'];
		$this->create();
		$this->save($order);
	}

}
?>
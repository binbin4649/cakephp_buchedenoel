<?php
class Sale extends AppModel {

	var $name = 'Sale';

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
		'InvoiceDateil' => array(
			'className' => 'InvoiceDateil',
			'foreignKey' => 'sale_id',
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
		'SalesDateil' => array(
			'className' => 'SalesDateil',
			'foreignKey' => 'sale_id',
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
		'Order' => array(
			'className' => 'Order',
			'joinTable' => 'orders_sales',
			'foreignKey' => 'sale_id',
			'associationForeignKey' => 'order_id',
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

	function searchOne($id){
		App::import('Model', 'User');
    	$UserModel = new User();
    	App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
		$sale = $this->read(null, $id);
    	$sale['Sale']['contact2_name'] = '';
    	$sale['Sale']['contact3_name'] = '';
    	$sale['Sale']['contact4_name'] = '';
		$params = array(
			'conditions'=>array('User.id'=>$sale['Sale']['contact1']),
			'recursive'=>0
		);
		$contact1 = $UserModel->find('first' ,$params);
		$sale['Sale']['contact1_name'] = $contact1['User']['name'];
		if(!empty($sale['Sale']['contact2'])){
			$params = array(
				'conditions'=>array('User.id'=>$sale['Sale']['contact2']),
				'recursive'=>0
			);
			$contact = $UserModel->find('first' ,$params);
			$sale['Sale']['contact2_name'] = $contact['User']['name'];
		}
		if(!empty($sale['Sale']['contact3'])){
			$params = array(
				'conditions'=>array('User.id'=>$sale['Sale']['contact3']),
				'recursive'=>0
			);
			$contact = $UserModel->find('first' ,$params);
			$sale['Sale']['contact3_name'] = $contact['User']['name'];
		}
		if(!empty($sale['Sale']['contact4'])){
			$params = array(
				'conditions'=>array('User.id'=>$sale['Sale']['contact4']),
				'recursive'=>0
			);
			$contact = $UserModel->find('first' ,$params);
			$sale['Sale']['contact4_name'] = $contact['User']['name'];
		}
		foreach($sale['SalesDateil'] as $key=>$value){
			$params = array(
				'conditions'=>array('Subitem.id'=>$value['subitem_id']),
				'recursive'=>0
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$sale['SalesDateil'][$key]['subitem_name'] = $subitem['Subitem']['name'];
		}
		return $sale;
	}
	
	//売上金額、前受金額、純売上金額、注残金額

	//部門別、日単位の売上金額、前受金額を出力。出荷先を抜かすので直営店用
	function AggreSaleDaySection($date, $section_id){
		App::import('Model', 'Order');
    	$OrderModel = new Order();
    	$conditions = array(
    		'Order.date'=>$date,
    		'Order.order_status <>'=>'5',
    		'Depot.section_id'=>$section_id
    	);
    	$params = array('conditions'=>$conditions, 'recursive'=>0);
		$orders = $OrderModel->find('all' ,$params);
		$prev_money_total = 0;
		foreach($orders as $order){
			$prev_money_total = $prev_money_total + $order['Order']['prev_money'];
		}

		$conditions = array(
    		'Sale.date'=>$date,
			'Sale.sale_type <>'=>3,
    		'Depot.section_id'=>$section_id
    	);
    	$params = array('conditions'=>$conditions, 'recursive'=>0);
		$sales = $this->find('all', $params);
		$sale_total_total = 0;
		foreach($sales as $sale){
			$sale_total_total = $sale_total_total + $sale['Sale']['total'];
		}
		$rsult = array('sale_total_total'=>$sale_total_total, 'prev_money_total'=>$prev_money_total);
		return $rsult;
	}
	
	//卸用　売上登録
	function WsSale($val){
		App::import('Model', 'Subitem');
    	$SubitemModel = new Subitem();
    	App::import('Model', 'SalesDateil');
    	$SalesDateilModel = new SalesDateil();
    	App::import('Component', 'Selector');
   		$SelectorComponent = new SelectorComponent();
		$order = $val['confirm']['Order'];
		$details = $val['confirm']['OrderDateil'];
		$sub_sale = $val['confirm']['Sale'];
		$total = $sub_sale['total'] + $order['shipping'] + $order['adjustment'];
		$sales['Sale'] = array(
			'sale_type'=>1, 'depot_id'=>null, 'destination_id'=>$order['destination_id'],
			'event_no'=>$order['events_no'], 'span_no'=>null, 'date'=>date('Y-m-d'),
			'contact1'=>$order['contact1'], 'contact2'=>$order['contact2'], 'contact3'=>$order['contact3'], 'contact4'=>$order['contact4'],
			'contribute1'=>null, 'contribute2'=>null, 'contribute3'=>null, 'contribute4'=>null,
			'customers_name'=>$order['customers_name'], 'partners_no'=>$order['partners_no'], 'total'=>$total,
			'item_price_total'=>$sub_sale['ex_total'], 'tax'=>$sub_sale['tax'], 'shipping'=>$order['shipping'],
			'adjustment'=>$order['adjustment'], 'total_day'=>$sub_sale['total_day'], 'remark'=>$sub_sale['remark'],
			'created_user'=>$sub_sale['created_user'], 'sale_status'=>1, 'section_id'=>309
		);
		$sales['Order'] = array($order['id']);
		$this->create();
		$this->save($sales);
		$sales_id = $this->getInsertID();
		$i = 1;
		foreach($details as $detail){
			$params = array(
				'conditions'=>array('Subitem.id'=>$detail['subitem_id']),
				'recursive'=>0,
				'fields' => array('Subitem.item_id', 'Subitem.major_size', 'Subitem.minority_size', 'Subitem.cost'),
			);
			$subitem = $SubitemModel->find('first' ,$params);
			$cost = $SelectorComponent->costSelector($subitem['Subitem']['item_id'], $subitem['Subitem']['cost']);
			$size = $SelectorComponent->sizeSelector($subitem['Subitem']['major_size'], $subitem['Subitem']['minority_size']);
			//ここから、配列あわせのつづき
			$sales_dateils['SalesDateil'] = array(
				'sale_id'=>$sales_id, 'detail_no'=>$i, 'item_id'=>$subitem['Subitem']['item_id'],
				'subitem_id'=>$detail['subitem_id'], 'size'=>$size, 'bid'=>$detail['bid'],
				'bid_quantity'=>$detail['sell_quantity'], 'cost'=>$cost,
				'marking'=>$detail['marking'], 'created_user'=>$sub_sale['created_user'],
				'ex_bid'=>$detail['ex_bid'], 'sub_remarks'=>$detail['sub_remarks']
			);
			$SalesDateilModel->create();
			$SalesDateilModel->save($sales_dateils);
			$i++;
		}
	}
	
	
	

}
?>
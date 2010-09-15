<?php
class OrderingsDetailsController extends AppController {

	var $name = 'OrderingsDetails';
	var $helpers = array("Javascript", "Ajax");
	var $uses = array('OrderingsDetail', 'Subitem', 'User', 'Depot', 'Ordering', 'Item', 'Order', 'Factory');
	//var $components = array('Selector');

	function add($ac = null, $id = null) {
		$total_jo = 0;
		$total_ge = 0;
		$total_quantity = 0;

		if(@$this->data['OrderingsDetail']['step'] == '1') {
			$params = array(
				'conditions'=>array('Item.name'=>$this->data['OrderingsDetail']['AutoItemName']),
				'recursive'=>0,
			);
			$item = $this->Item->find('first' ,$params);
			if($item){
				$this->set('item', $item);
				$params = array(
					'conditions'=>array('Subitem.item_id'=>$item['Item']['id']),
					'recursive'=>0,
					'order'=>array('Subitem.name'=>'asc')
				);
				$subitems = $this->Subitem->find('all' ,$params);
				if(empty($subitems)){
					$this->Session->setFlash('子品番が登録されていません。');
				}
				//labor_costがemptyだった場合、Itemのcostを入れる
				foreach($subitems as $key=>$value){
					if(empty($value['Subitem']['labor_cost'])){
						$subitems[$key]['Subitem']['labor_cost'] = $item['Item']['cost'];
					}
				}
				$this->set('subitems', $subitems);
				$params = array(
					'conditions'=>array('User.id'=>$this->Auth->user('id')),
					'recursive'=>0,
				);
				$user = $this->User->find('first' ,$params);
				$this->set('user', $user);
				$params = array(
					'conditions'=>array('Depot.section_id'=>$user['User']['section_id']),
					'recursive'=>0,
				);
				$depots = $this->Depot->find('list' ,$params);
				$this->set('depots', $depots);
			}else{
				$this->Session->setFlash('品番は正確に入力して下さい。');
			}
		}
		if(@$this->data['OrderingsDetail']['step'] == '2') {
			$params = array(
				'conditions'=>array('Depot.id'=>$this->data['OrderingsDetail']['depot']),
				'recursive'=>0,
				'fields'=>array('Depot.name')
			);
			$depot = $this->Depot->find('first' ,$params);
			if(!empty($this->data['OrderingsDetail']['order_id'])){
				$this->data['OrderingsDetail']['order_id'] = mb_convert_kana($this->data['OrderingsDetail']['order_id'], 'a', 'UTF-8');
				$this->data['OrderingsDetail']['order_id'] = ereg_replace("[^0-9]", "", $this->data['OrderingsDetail']['order_id']);//半角数字以外を削除
				$params = array(
					'conditions'=>array('Order.id'=>$this->data['OrderingsDetail']['order_id']),
					'recursive'=>1,
				);
				$order = $this->Order->find('first' ,$params);
				if(!$order)$this->Session->setFlash(__('そんな受注番号はありません。', true));
			}
			if($this->data['Item']['stock_code'] == '3'){
				if($order AND !empty($order['OrderDateil'][0]['subitem_id'])){
					$this->data['subitem'] = array($order['OrderDateil'][0]['subitem_id']=>1);
				}else{
					$this->Session->setFlash(__('単品注文の発注は必ず受注番号も入れてください。', true));
				}
			}
			
			
			//pr($this->data['subitem']);
			$subitems = array_keys($this->data['subitem']);
			foreach($subitems as $subitem_id){
				if($this->data['subitem'][$subitem_id] > 0){
					$params = array(
						'conditions'=>array('Subitem.id'=>$subitem_id),
						'recursive'=>0
					);
					$subitem = $this->Subitem->find('first' ,$params);
					//仕入原価（labor_cost）が入っていなかったら、親品番の原価(cost)を採用する。&その逆str_replace
					if(empty($subitem['Subitem']['labor_cost'])) {
						$this->data['Subitem']['labor_cost'] = $subitem['Item']['cost'];
					}else{
						$this->data['Subitem']['labor_cost'] = $subitem['Subitem']['labor_cost'];
					}
					//テキストボックスから原価が入力されたら、その値に変える
					if(!empty($this->data['OrderingsDetail']['changecost'])) $this->data['Subitem']['labor_cost'] = $this->data['OrderingsDetail']['changecost'];
					// factory_id が入っていたら工場をそれに変更
					if(!empty($this->data['OrderingsDetail']['factory_id'])){
						$this->data['OrderingsDetail']['factory_id'] = mb_convert_kana($this->data['OrderingsDetail']['factory_id'], 'a', 'UTF-8');
						$this->data['OrderingsDetail']['factory_id'] = ereg_replace("[^0-9]", "", $this->data['OrderingsDetail']['factory_id']);//半角数字以外を削除
						$factory_name = $this->Factory->isName($this->data['OrderingsDetail']['factory_id']);
						if($factory_name){
							$this->data['Factory']['name'] = $factory_name;
							$this->data['Factory']['id'] = $this->data['OrderingsDetail']['factory_id'];
						}
					}
					//強制半角＆コードを短く
					$qty = mb_convert_kana($this->data['subitem'][$subitem['Subitem']['id']], 'a', 'UTF-8');
					$session_write['Subitem']['id'] =  $subitem['Subitem']['id'];
					$session_write['Subitem']['name'] =  $subitem['Subitem']['name'];
					$session_write['Subitem']['jan'] =  $subitem['Subitem']['jan'];
					$session_write['Subitem']['quantity'] = $this->data['subitem'][$subitem_id];
					$session_write['Subitem']['major_size'] = $subitem['Subitem']['major_size'];
					$session_write['Subitem']['minority_size'] = $subitem['Subitem']['minority_size'];
					$session_write['Item']['id'] =  $subitem['Subitem']['item_id'];
					$session_write['Item']['stock_code'] =  $this->data['Item']['stock_code'];
					$session_write['Subitem']['cost'] =  $this->data['Subitem']['labor_cost'];
					$session_write['Item']['price'] =  $this->data['Item']['price'];
					$session_write['Item']['sub_total_jo'] =  $this->data['Item']['price'] * $qty;
					$session_write['Item']['sub_total_ge'] =  $this->data['Subitem']['labor_cost'] * $qty;
					$session_write['Section']['name'] =  $this->data['Section']['name'];
					$session_write['Factory']['name'] =  $this->data['Factory']['name'];
					$session_write['Factory']['id'] =  $this->data['Factory']['id'];
					$session_write['Depot']['id'] =  $depot['Depot']['id'];
					$session_write['Depot']['name'] =  $depot['Depot']['name'];
					$session_write['specified_date'] =  $this->data['OrderingsDetail']['specified_date'];
					$session_write['order_id'] =  $this->data['OrderingsDetail']['order_id'];
					//単品管理の場合は、子品番の変わりにJANコードを入れる
					if($this->data['Item']['stock_code'] == '3'){
						$subitem_name = $subitem['Subitem']['jan'];
					}else{
						$subitem_name = $subitem['Subitem']['name'];
					}
					$this->Session->write("OrderingsDetail.".$subitem_id, $session_write);
				}
			}
		}
		if($this->Session->check('OrderingsDetail')){
			$details = array();
			$session_read = $this->Session->read('OrderingsDetail');
			if($ac == 'del'){
				/* 5/12修正
				$params = array(
					'conditions'=>array('Subitem.id'=>$id),
					'recursive'=>0,
					'fields'=>array('Subitem.name', 'Subitem.jan')
				);
				$del_subitem = $this->Subitem->find('first' ,$params);
				$this->Session->delete("OrderingsDetail.".$del_subitem['Subitem']['name']);
				*/
				$this->Session->delete("OrderingsDetail.".$id);
				unset($session_read[$id]);
			}
			if($ac == 'alldel'){
				$this->Session->delete("OrderingsDetail");
				$session_read = array();
			}
			if($ac == 'spesial' or $ac == 'basic' or $ac == 'custom' or $ac == 'repair' or $ac == 'other'){
				$Ordering = array();
				$OrderingsDetail = array();
				foreach($session_read as $key=>$value){
					$Ordering = array();
					$OrderingsDetail = array();
					if($ac == 'other') $orderings_type = 99;
					if($ac == 'repair') $orderings_type = 4;
					if($ac == 'spesial') $orderings_type = 3;
					if($ac == 'basic') $orderings_type = 2;
					if($ac == 'custom') $orderings_type = 1;
					$params = array(
						'conditions'=>array('and'=>array(
							'Ordering.factory_id'=>$value['Factory']['id'],
							'Ordering.ordering_status'=>1,
							'Ordering.orderings_type'=>$orderings_type,
						)),
						'recursive'=>0
					);
					$Ordering = $this->Ordering->find('first' ,$params);
					if($Ordering == false){
						$Ordering['Ordering']['ordering_status'] = 1;
						$Ordering['Ordering']['factory_id'] = $value['Factory']['id'];
						$Ordering['Ordering']['created_user'] = $this->Auth->user('id');
						$Ordering['Ordering']['orderings_type'] = $orderings_type;
						$this->Ordering->save($Ordering);
						$Ordering['Ordering']['id'] = $this->Ordering->getInsertID();
						$this->Ordering->id = null;
					}
					$OrderingsDetail['OrderingsDetail']['ordering_id'] = $Ordering['Ordering']['id'];
					$OrderingsDetail['OrderingsDetail']['subitem_id'] = $value['Subitem']['id'];
					$OrderingsDetail['OrderingsDetail']['item_id'] = $value['Item']['id'];
					$OrderingsDetail['OrderingsDetail']['major_size'] = $value['Subitem']['major_size'];
					$OrderingsDetail['OrderingsDetail']['minority_size'] = $value['Subitem']['minority_size'];
					$OrderingsDetail['OrderingsDetail']['depot'] = $value['Depot']['id'];
					$OrderingsDetail['OrderingsDetail']['specified_date'] = $value['specified_date'];
					$OrderingsDetail['OrderingsDetail']['order_id'] = $value['order_id'];
					$OrderingsDetail['OrderingsDetail']['bid'] = $value['Subitem']['cost'];
					$OrderingsDetail['OrderingsDetail']['ordering_quantity'] = $value['Subitem']['quantity'];
					$OrderingsDetail['OrderingsDetail']['created_user'] = $this->Auth->user('id');
					$this->OrderingsDetail->save($OrderingsDetail);
					$this->OrderingsDetail->id = null;
				}
				$this->Session->delete("OrderingsDetail");
				$this->redirect(array('controller'=>'orderings', 'action'=>'index'));
			}
			foreach($session_read as $key=>$value){
				//単品管理の場合は、子品番の変わりにJANコードを入れる
				if($value['Item']['stock_code'] == '3'){
					$key = $value['Subitem']['jan'];
				}else{
					$key = $value['Subitem']['name'];
				}
				/* 5/12修正
				if($ac == 'del'){
					if($del_subitem['Subitem']['name'] == $key){
					}else{
						$total_jo = $total_jo + $value['Item']['sub_total_jo'];
						$total_ge = $total_ge + $value['Item']['sub_total_ge'];
						$total_quantity = $total_quantity + $value['Subitem']['quantity'];
						$details[$key] = $value;
					}
				}else{
					$total_jo = $total_jo + $value['Item']['sub_total_jo'];
					$total_ge = $total_ge + $value['Item']['sub_total_ge'];
					$total_quantity = $total_quantity + $value['Subitem']['quantity'];
					$details[$key] = $value;
				}
				*/
				$total_jo = $total_jo + $value['Item']['sub_total_jo'];
				$total_ge = $total_ge + $value['Item']['sub_total_ge'];
				$total_quantity = $total_quantity + $value['Subitem']['quantity'];
				$details[$key] = $value;
			}
			$detailTotal['jo'] = $total_jo;
			$detailTotal['ge'] = $total_ge;
			$detailTotal['quantity'] = $total_quantity;
			$this->set('detailTotal', $detailTotal);
			$this->set('details', $details);
		}
	}//add終わり

	function getData(){
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>'%'.$this->data['OrderingsDetail']['AutoItemName'].'%'),
			'recursive'=>0,
			'limit'=>20,
			'order'=>array('Item.name'=>'asc'),
			'fields'=>array('Item.name')
		);
		$result = $this->Item->find('all', $params);
		if(!empty($result)){
			foreach($result as $values){
				$Autoitems[] = $values['Item']['name'];
			}
		}else{
			$Autoitems[] = '違います';
		}
		$this->set("Autoitems",$Autoitems);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid OrderingsDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data['OrderingsDetail']['id'])) {
			if ($this->OrderingsDetail->save($this->data)) {
				$this->Session->setFlash(__('The OrderingsDetail has been saved', true));
				$this->redirect(array('controller'=>'orderings','action'=>'view', $this->data['OrderingsDetail']['ordering_id']));
			} else {
				$this->Session->setFlash(__('The OrderingsDetail could not be saved. Please, try again.', true));
			}
		}
		$this->data = $this->OrderingsDetail->read(null, $id);
		$depots = $this->Depot->find('list');
		$this->set(compact('depots'));
	}

}
?>
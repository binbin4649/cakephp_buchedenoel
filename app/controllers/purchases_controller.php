<?php
class PurchasesController extends AppController {

	var $name = 'Purchases';
	var $helpers = array('AddForm');
	var $uses = array('Purchase', 'PurchaseDetail', 'Ordering',  'OrderingsDetail', 'Subitem', 'User', 'Depot', 'Factory', 'Stock', 'Item');
	var $components = array('Total', 'Print', 'Selector');

	function index() {
		$modelName = 'Purchase';
		$statusName = 'purchase_status';
		if (!empty($this->data[$modelName]['word']) or !empty($this->data[$modelName]['status'])) {
			$seach_word = $this->data[$modelName]['word'];
			$seach_status = $this->data[$modelName]['status'];
			$conditions['or'] = array($modelName.'.id'=>$seach_word, $modelName.'.'.$statusName=>$seach_status);
			$this->paginate = array(
				'conditions'=>$conditions,
				'limit'=>60,
				'order'=>array($modelName.'.date'=>'desc')
			);
		}else{
			$this->paginate = array(
				'conditions'=>array(),
				'limit'=>60,
				'order'=>array($modelName.'.date'=>'desc')
			);
		}

		$this->Purchase->recursive = 0;
		$index_view = $this->paginate();
		$purchase_status = get_purchase_status();
		$index_out = array();
		foreach($index_view as $index){
			$params = array(
				'conditions'=>array('User.id'=>$index['Purchase']['created_user']),
				'recursive'=>0,
			);
			$user = $this->User->find('first' ,$params);
			$index['Purchase']['created_user_name'] = $user['User']['name'];
			$index['Purchase']['purchase_status_name'] = $purchase_status[$index['Purchase']['purchase_status']];
			$index_out[] = $index;
		}
		$this->set('purchases', $index_out);
		$this->set(compact('purchase_status'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Purchase.', true));
			$this->redirect(array('action'=>'index'));
		}
		$params = array(
			'conditions'=>array('Purchase.id'=>$id),
			'recursive'=>1,
		);
		$Purchase = $this->Purchase->find('first' ,$params);
		foreach($Purchase['PurchaseDetail'] as $key=>$detail){
			$params = array(
				'conditions'=>array('Subitem.id'=>$detail['subitem_id']),
				'recursive'=>0,
			);
			$subitem = $this->Subitem->find('first' ,$params);
			$Purchase['PurchaseDetail'][$key]['stock_code'] = $subitem['Item']['stock_code'];
			$Purchase['PurchaseDetail'][$key]['subitem_name'] = $subitem['Subitem']['name'];
			$params = array(
				'conditions'=>array('Depot.id'=>$detail['depot']),
				'recursive'=>0,
			);
			$depot = $this->Depot->find('first' ,$params);
			$Purchase['PurchaseDetail'][$key]['depot_name'] = $depot['Depot']['name'];
		}
		$this->set('purchase', $Purchase);

		$purchase_status = get_purchase_status();
		$this->set(compact('purchase_status'));

		if(!empty($Purchase['Purchase']['print_file'])){
			$print_out['url'] = '/buchedenoel/files/purchase/'.$Purchase['Purchase']['print_file'].'.php';
			$print_out['file'] = $Purchase['Purchase']['print_file'].'.pxd';
			$this->set('print', $print_out);
		}
	}

	function add($ac = null, $id = null) {
		$this->Session->delete("Purchase");
		$this->Session->delete("PurchaseDetail");
		if(!empty($this->data)){
			$params = array(
				'conditions'=>array('Factory.id'=>$this->data['Purchase']['factory_id']),
				'recursive'=>0,
			);
			$factory = $this->Factory->find('first' ,$params);
			$purchases['Purchase']['purchase_status'] = 1;
			$purchases['Purchase']['ordering_id'] = $this->data['Purchase']['ordering_id'];
			$purchases['Purchase']['invoices'] = $this->data['Purchase']['invoices'];
			$purchases['Purchase']['factory_id'] = $this->data['Purchase']['factory_id'];
			$purchases['Purchase']['date'] = $this->data['Purchase']['date'];
			$purchases['Purchase']['remark'] = $this->data['Purchase']['remark'];
			$i = 0;
			foreach($this->data['PurchaseDetail'] as $key=>$value){
				$sub_total[$i]['money'] = $value['bid'];
				$sub_total[$i]['quantity'] = $value['quantity'];
				$i++;
				$params = array(
					'conditions'=>array('OrderingsDetail.id'=>$key),
					'recursive'=>0,
				);
				$detail = $this->OrderingsDetail->find('first' ,$params);
				$PurchaseDetail['PurchaseDetail']['order_id'] = $detail['OrderingsDetail']['order_id'];
				$PurchaseDetail['PurchaseDetail']['order_dateil_id'] = $detail['OrderingsDetail']['order_dateil_id'];
				$PurchaseDetail['PurchaseDetail']['ordering_id'] = $detail['OrderingsDetail']['ordering_id'];
				$PurchaseDetail['PurchaseDetail']['ordering_dateil_id'] = $detail['OrderingsDetail']['id'];
				$PurchaseDetail['PurchaseDetail']['item_id'] = $detail['OrderingsDetail']['item_id'];
				$PurchaseDetail['PurchaseDetail']['subitem_id'] = $detail['OrderingsDetail']['subitem_id'];
				$PurchaseDetail['PurchaseDetail']['bid'] = $value['bid'];
				$PurchaseDetail['PurchaseDetail']['quantity'] = $value['quantity'];
				$PurchaseDetail['PurchaseDetail']['depot'] = $value['depot'];
				$this->Session->write("PurchaseDetail.".$i, $PurchaseDetail);
			}
			$slip_total = $this->Total->slipTotal($sub_total, $factory['Factory']['tax_method'], $factory['Factory']['tax_fraction']);
			$purchases['Purchase']['detail_total'] = $slip_total['detail_total'];
			$purchases['Purchase']['total_tax'] = $slip_total['tax'];
			if(empty($this->data['Purchase']['shipping']))$this->data['Purchase']['shipping'] = 0;
			$purchases['Purchase']['shipping'] = $this->data['Purchase']['shipping'];
			if(empty($this->data['Purchase']['adjustment']))$this->data['Purchase']['adjustment'] = 0;
			$purchases['Purchase']['adjustment'] = $this->data['Purchase']['adjustment'];
			$purchases['Purchase']['total'] = $slip_total['total'] + $this->data['Purchase']['shipping'] + $this->data['Purchase']['adjustment'];
			$this->Session->write("Purchase", $purchases);
			$this->redirect(array('action'=>'add_confirm'));
		}

		if($ac == 'buying'){
			$params = array(
				'conditions'=>array('Ordering.id'=>$id),
				'recursive'=>1,
			);
			$ordering = $this->Ordering->find('first' ,$params);
			$params = array(
				'conditions'=>array('OrderingsDetail.ordering_id'=>$id),
				'recursive'=>0,
			);
			$details = $this->OrderingsDetail->find('all' ,$params);
			$params = array(
				'conditions'=>array('Depot.section_id'=>$this->Auth->user('section_id')),
				'recursive'=>0,
			);
			$depots = $this->Depot->find('list' ,$params);
			$this->set(compact('ordering', 'details', 'depots'));
		}
	}

	function add_confirm($ac = null, $id = null){
		if($this->Session->check('Purchase')){
			$Purchase = $this->Session->read('Purchase');
			$PurchaseDetail = $this->Session->read('PurchaseDetail');
			$params = array(
				'conditions'=>array('Factory.id'=>$Purchase['Purchase']['factory_id']),
				'recursive'=>0,
			);
			$factory = $this->Factory->find('first' ,$params);
			$Purchase['Factory'] = $factory['Factory'];
			$Purchase['Purchase']['date'] = $Purchase['Purchase']['date']['year'].'-'.$Purchase['Purchase']['date']['month'].'-'.$Purchase['Purchase']['date']['day'];
			foreach($PurchaseDetail as $key=>$value){
				$params = array(
					'conditions'=>array('Subitem.id'=>$value['PurchaseDetail']['subitem_id']),
					'recursive'=>0,
				);
				$subitem = $this->Subitem->find('first' ,$params);
				$PurchaseDetail[$key]['Subitem'] = $subitem['Subitem'];
				$PurchaseDetail[$key]['Item'] = $subitem['Item'];

				$params = array(
					'conditions'=>array('Depot.id'=>$value['PurchaseDetail']['depot']),
					'recursive'=>0,
				);
				$depot = $this->Depot->find('first' ,$params);
				$PurchaseDetail[$key]['Depot'] = $depot['Depot'];
			}
			$purchase_status = get_purchase_status();

			if($ac == 'ok'){
				$Purchase['Purchase']['purchase_status'] = 2;
				$Purchase['Purchase']['created_user'] = $this->Auth->user('id');
				$this->Purchase->save($Purchase['Purchase']);
				$purchases_id = $this->Purchase->getInsertID();
				foreach($PurchaseDetail as $detail){
					$params = array(
						'conditions'=>array('OrderingsDetail.id'=>$detail['PurchaseDetail']['ordering_dateil_id']),
						'recursive'=>0,
					);
					$orderings_detail = $this->OrderingsDetail->find('first' ,$params);
					$OrderingsDetail['OrderingsDetail']['id'] = $detail['PurchaseDetail']['ordering_dateil_id'];
					$OrderingsDetail['OrderingsDetail']['stock_quantity'] = $detail['PurchaseDetail']['quantity'] + $orderings_detail['OrderingsDetail']['stock_quantity'];
					$this->OrderingsDetail->save($OrderingsDetail);
					$this->OrderingsDetail->id = null;
					$detail['PurchaseDetail']['purchase_id'] = $purchases_id;
					$detail['PurchaseDetail']['created_user'] = $this->Auth->user('id');
					$this->PurchaseDetail->save($detail['PurchaseDetail']);
					$this->PurchaseDetail->id = null;
					$this->Stock->Plus($detail['PurchaseDetail']['subitem_id'], $detail['PurchaseDetail']['depot'], $detail['PurchaseDetail']['quantity'], $this->Auth->user('id'), 1);
					//コストに変更がある場合は、コストを計算する
					//単品管理の商品は省く
					$params = array(
						'conditions'=>array('Item.id'=>$detail['Subitem']['item_id']),
						'recursive'=>0,
					);
					$item = $this->Item->find('first' ,$params);
					if($item['Item']['stock_code'] != 3){
						$cost = $this->Selector->costSelector($detail['Subitem']['item_id'], $detail['Subitem']['cost']);
						if($detail['PurchaseDetail']['bid'] != $cost){
							$total_quantity = 0;
							$params = array(
								'conditions'=>array('and'=>array('Stock.subitem_id'=>$detail['PurchaseDetail']['subitem_id'], 'Stock.quantity >'=>0)),
								'recursive'=>0,
							);
							$Stocks = $this->Stock->find('all' ,$params);
							foreach($Stocks as $stock){
								$total_quantity = $total_quantity + $stock['Stock']['quantity'];
							}
							$old_cost_total = $cost * $total_quantity;
							$new_cost_total = $detail['PurchaseDetail']['quantity'] * $detail['PurchaseDetail']['bid'];
							$new_quantity = $detail['PurchaseDetail']['quantity'] + $total_quantity;
							$new_cost = ($old_cost_total + $new_cost_total) / $new_quantity;
							//四捨五入　round(
							$Subitem = array();
							$Subitem['Subitem']['id'] = $detail['PurchaseDetail']['subitem_id'];
							$Subitem['Subitem']['cost'] = round($new_cost);
							$this->Subitem->save($Subitem);
							$this->Subitem->id = null;
						}
					}
				}
				$params = array(
					'conditions'=>array('Ordering.id'=>$Purchase['Purchase']['ordering_id']),
					'recursive'=>1,
				);
				$Ordering = $this->Ordering->find('first' ,$params);
				$ordering_jugement = true;
				foreach($Ordering['OrderingsDetail'] as $OrderingsDetail){//発注数量と入荷数量を比べて、入荷数量が多いか同じで発注ステータスを完了にする。
					if($OrderingsDetail['ordering_quantity'] > $OrderingsDetail['stock_quantity']){
						$ordering_jugement = false;
					}
				}
				if($ordering_jugement){
					$Ordering['Ordering']['id'] = $Purchase['Purchase']['ordering_id'];
					$Ordering['Ordering']['ordering_status'] = 5;
					$this->Ordering->save($Ordering);
					$this->Session->setFlash(__('発注番号：'.$Ordering['Ordering']['id'].'　のステータスを「入荷済み」に変更しました。', true));
				}

				$Purchase['Purchase']['id'] = $purchases_id;
				$file_name = 'purchase'.$purchases_id.'-'.date('Ymd-His');
				$path = WWW_ROOT.'/files/purchase/';
				$print_xml = $this->Print->purchase($Purchase, $PurchaseDetail, $file_name);
				file_put_contents($path.$file_name.'.php', $print_xml);
				$Purchase['Purchase']['print_file'] = $file_name;
				$this->Purchase->save($Purchase);
				$this->Session->delete("Purchase");
				$this->Session->delete("PurchaseDetail");
			}
			$this->set(compact('Purchase', 'PurchaseDetail', 'purchase_status'));

			if(!empty($Purchase['Purchase']['print_file'])){
				$print_out['url'] = '/buchedenoel/files/purchase/'.$Purchase['Purchase']['print_file'].'.php';
				$print_out['file'] = $Purchase['Purchase']['print_file'].'.pxd';
				$this->set('print', $print_out);
			}
		}
	}


	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Purchase', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Purchase->save($this->data)) {
				$this->Session->setFlash(__('The Purchase has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Purchase']['id']));
			} else {
				$this->Session->setFlash(__('The Purchase could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Purchase->read(null, $id);
		}
		$factories = $this->Purchase->Factory->find('list');
		$purchase_status = get_purchase_status();
		$this->set(compact('factories','purchase_status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Purchase', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Purchase->del($id)) {
			$this->Session->setFlash(__('Purchase deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
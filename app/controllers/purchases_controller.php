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
		if($ac == 'return' AND $this->Session->check('PurchaseDetail')){
			$PurchaseDetail = $this->Session->read('PurchaseDetail');
			foreach($PurchaseDetail as $key=>$value){
				$value['quantity'];
				if($value['quantity'] > 0){
					$PurchaseDetail[$key]['quantity'] = '-'.$value['quantity'];
				}
			}
			$this->Session->write("PurchaseDetail", $PurchaseDetail);
			$ac = 'direct';
		}
		if($ac == 'direct'){
			if($this->Session->check('PurchaseDetail')){
				$this->data['PurchaseDetail'] = $this->Session->read('PurchaseDetail');
				foreach($this->data['PurchaseDetail'] as $key=>$value){
					$this->data['Purchase'] = array(
						'ordering_id'=>'',
						'factory_id'=>$value['factory_id'],
						'invoices'=>'',
						'date'=>date('Y-m-d'),
						'shipping'=>'',
						'adjustment'=>'',
						'remark'=>'',
						'created_user'=>$this->Auth->user('id'),
					);
					break;
				}
			}
		}
		
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
				
				/*　20121210これ消した。そもそもこれ、なんなんだ？
				$params = array(
					'conditions'=>array('OrderingsDetail.id'=>$key),// $key はsubitem_id じゃなくて OrderingsDetail_id でした!
					'recursive'=>0,
				);
				$detail = $this->OrderingsDetail->find('first' ,$params);
				*/
				$detail = null;
				
				if($detail){//直接入力は発注が無い　そもそもこれ可笑しくない？ janコードでdetailとって来ているよね？可笑しくね？
					$PurchaseDetail['PurchaseDetail']['order_id'] = $detail['OrderingsDetail']['order_id'];
					$PurchaseDetail['PurchaseDetail']['order_dateil_id'] = $detail['OrderingsDetail']['order_dateil_id'];
					$PurchaseDetail['PurchaseDetail']['ordering_id'] = $detail['OrderingsDetail']['ordering_id'];
					$PurchaseDetail['PurchaseDetail']['ordering_dateil_id'] = $detail['OrderingsDetail']['id'];
					$PurchaseDetail['PurchaseDetail']['item_id'] = $detail['OrderingsDetail']['item_id'];
					$PurchaseDetail['PurchaseDetail']['subitem_id'] = $detail['OrderingsDetail']['subitem_id'];
				}else{//とりあえず、直接はこちら
					$PurchaseDetail['PurchaseDetail']['order_id'] = '';
					$PurchaseDetail['PurchaseDetail']['order_dateil_id'] = '';
					$PurchaseDetail['PurchaseDetail']['ordering_id'] = '';
					$PurchaseDetail['PurchaseDetail']['ordering_dateil_id'] = '';
					$PurchaseDetail['PurchaseDetail']['item_id'] = $value['item_id'];
					$PurchaseDetail['PurchaseDetail']['subitem_id'] = $value['subitem_id'];
				}
				$PurchaseDetail['PurchaseDetail']['bid'] = $value['bid'];
				$PurchaseDetail['PurchaseDetail']['quantity'] = $value['quantity'];
				$PurchaseDetail['PurchaseDetail']['depot'] = $value['depot'];
				$this->Session->write("PurchaseDetail.".$i, $PurchaseDetail);
			}
			$slip_total = $this->Total->slipTotal($sub_total, $factory['Factory']['tax_method'], $factory['Factory']['tax_fraction']);
			$purchases['Purchase']['detail_total'] = $slip_total['detail_total']; //detail_total = 簡単に言うと税抜き。請求単位とか明細単位に計算する時に使う
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
	
	//直接仕入を入力
	function direct($ac = null, $subitem_id = null){
		$message_controller = 0;
		$session_reader = array();
		$session_base = array();
		$depot_name = '';
		if($ac == 'reset'){
			$this->Session->delete('PurchaseDetail');
		}
		if($ac == 'del'){
			$this->Session->delete('PurchaseDetail.'.$subitem_id);
		}
		if($this->Session->check('PurchaseDetail')){
			$session_reader = $this->Session->read('PurchaseDetail');
		}
		
		if(!empty($this->data['Purchase']['Qty'])){//数量変更のeditボタンを押されたら、数量を変更する
			$this->data['Purchase']['depot'] = $this->data['Purchase']['depot_id'];
			foreach($this->data['Purchase']['Qty'] as $key=>$value){
				$value = mb_convert_kana($value, 'a', 'UTF-8');
				$value = ereg_replace("[^0-9\-]", "", $value);//半角数字とハイフン以外を削除
				if($value == 0){//0だと消す処理
					unset($session_reader[$key]);
				}elseif($session_reader[$key]['quantity'] != $value){
					$session_reader[$key]['quantity'] = $value;
				}
			}
			$this->Session->write("PurchaseDetail", $session_reader);
		}
		
		if(!empty($this->data['Purchase']['depot'])){
			$depot_name = $this->Depot->getName($this->data['Purchase']['depot']);
			if(empty($depot_name)){
				$this->Session->setFlash('倉庫番号を間違えています。');
				$this->params['form']['input1'] = null;
			}else{
				$depot_name = mb_substr($depot_name, 0, 8);
				$depot_name = $depot_name.':'.$this->data['Purchase']['depot'];
				if(!empty($this->params['form']['input1'])){
					$jan = $this->params['form']['input1'];
					$jan = mb_convert_kana($jan, 'a', 'UTF-8');
					$jan = ereg_replace("[^0-9]", "", $jan);//半角数字以外を削除
					$params = array(
						'conditions'=>array('Subitem.jan'=>$jan),
						'recursive'=>1
					);
					$this->Subitem->contain('Item');
					$subitem = $this->Subitem->find('first' ,$params);
					
					// 工場は一つに絞る
					foreach($session_reader as $key=>$value){
						if($value['factory_id'] != $subitem['Item']['factory_id'] AND !empty($subitem)){
							$subitem = false;
							$message_controller = 1;
						}
					}
					if($subitem){
						$cost = $this->Selector->costSelector($subitem['Subitem']['item_id'], $subitem['Subitem']['cost']);
						$factory_name = $this->Factory->cleaningName($subitem['Item']['factory_id']);
						$factory_name = mb_substr($factory_name, 0, 8);
						$session_reader[$subitem['Subitem']['id']] = array(
							'subitem_name'=>$subitem['Subitem']['name'],
							'subitem_id'=>$subitem['Subitem']['id'],
							'subitem_jan'=>$subitem['Subitem']['jan'],
							'depot_name'=>$depot_name,
							'depot'=>$this->data['Purchase']['depot'],
							'bid'=>$cost,
							'factory_name'=>$factory_name,
							'factory_id'=>$subitem['Item']['factory_id'],
							'item_id'=>$subitem['Item']['id'],
							'quantity'=>1
						);
						$this->Session->write("PurchaseDetail", $session_reader);
					}else{
						if($message_controller == 1){
							$this->Session->setFlash('異なる工場は入力できません。');
						}else{
							$this->Session->setFlash('JANコードが見当たりません。');
						}
					}
				}
			}
		}elseif(!empty($this->params['form']['input1'])){
			$this->Session->setFlash('最初は必ず倉庫番号を入力して下さい。');
		}
		
		if(!empty($session_reader)){
			//戻るボタンを押された時に配列の構造を直して足りない項目を追加する
			if(!empty($session_reader[1]['PurchaseDetail']) OR !empty($session_reader[0]['PurchaseDetail'])){
				$ex_reader = array();
				foreach($session_reader as $value){
					$subitem_id = $value['PurchaseDetail']['subitem_id'];
					$params = array(
						'conditions'=>array('Subitem.id'=>$subitem_id),
						'recursive'=>1
					);
					$this->Subitem->contain('Item');
					$subitem = $this->Subitem->find('first' ,$params);
					$factory_name = $this->Factory->cleaningName($subitem['Item']['factory_id']);
					$factory_name = mb_substr($factory_name, 0, 8);
					$depot_name = $this->Depot->getName($value['PurchaseDetail']['depot']);
					$ex_reader[$subitem_id]['subitem_name'] = $subitem['Subitem']['name'];
					$ex_reader[$subitem_id]['subitem_id'] = $value['PurchaseDetail']['subitem_id'];
					$ex_reader[$subitem_id]['subitem_jan'] = $subitem['Subitem']['jan'];
					$ex_reader[$subitem_id]['depot_name'] = $depot_name.':'.$value['PurchaseDetail']['depot'];
					$ex_reader[$subitem_id]['depot'] = $value['PurchaseDetail']['depot'];
					$ex_reader[$subitem_id]['bid'] = $value['PurchaseDetail']['bid'];
					$ex_reader[$subitem_id]['factory_name'] = $factory_name;
					$ex_reader[$subitem_id]['factory_id'] = $subitem['Item']['factory_id'];
					$ex_reader[$subitem_id]['item_id'] = $subitem['Item']['id'];
					$ex_reader[$subitem_id]['quantity'] = $value['PurchaseDetail']['quantity'];
				}
				$session_reader = array();
				$session_reader = $ex_reader;
				$this->Session->write("PurchaseDetail", $session_reader);
			}
			$this->set('PurchaseDetail',$session_reader);
		}elseif($this->Session->check('PurchaseDetail')){
			$session_reader = $this->Session->read('PurchaseDetail');
			$this->set('PurchaseDetail',$session_reader);
		}
	}

	function add_confirm($ac = null, $id = null){
		$mimus_result = true;//返品時、在庫を減らしてない時にメッセージを出すか？を操作する。
		$return_juge = false;// true で返品にステータスを変える
		if($this->Session->check('Purchase')){
			$Purchase = $this->Session->read('Purchase');
			if(empty($Purchase['Purchase']['ordering_id'])){//発注IDが無い場合はdirectと見なし戻るボタンを操作する
				$this->set('historyBack', 'direct');
			}
			$PurchaseDetail = $this->Session->read('PurchaseDetail');
			$factory_name = $this->Factory->cleaningName($Purchase['Purchase']['factory_id']);
			$Purchase['Factory']['name'] = mb_substr($factory_name, 0, 16);
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
					if(!empty($detail['PurchaseDetail']['ordering_dateil_id'])){//通常はこちら
						$params = array(
							'conditions'=>array('OrderingsDetail.id'=>$detail['PurchaseDetail']['ordering_dateil_id']),
							'recursive'=>0,
						);
						$orderings_detail = $this->OrderingsDetail->find('first' ,$params);
						$OrderingsDetail['OrderingsDetail']['id'] = $detail['PurchaseDetail']['ordering_dateil_id'];
						$OrderingsDetail['OrderingsDetail']['stock_quantity'] = $detail['PurchaseDetail']['quantity'] + $orderings_detail['OrderingsDetail']['stock_quantity'];
						$this->OrderingsDetail->save($OrderingsDetail);
						$this->OrderingsDetail->id = null;
					}
					$detail['PurchaseDetail']['purchase_id'] = $purchases_id;
					$detail['PurchaseDetail']['created_user'] = $this->Auth->user('id');
					$this->PurchaseDetail->save($detail['PurchaseDetail']);
					$this->PurchaseDetail->id = null;
					if($detail['PurchaseDetail']['quantity'] >= 1){
						if(EMERGENCY_LANDING == TRUE AND $detail['Item']['stock_code'] == 3){
						}else{
							$this->Stock->Plus($detail['PurchaseDetail']['subitem_id'], $detail['PurchaseDetail']['depot'], $detail['PurchaseDetail']['quantity'], $this->Auth->user('id'), 1);
						}
					}elseif($detail['PurchaseDetail']['quantity'] < 0){
						$return_juge = true;
						$qty = str_replace('-', '', $detail['PurchaseDetail']['quantity']);
						if(EMERGENCY_LANDING == TRUE AND $detail['Item']['stock_code'] == 3){
						}else{
							$mimus_result = $this->Stock->Mimus($detail['PurchaseDetail']['subitem_id'], $detail['PurchaseDetail']['depot'], $qty, $this->Auth->user('id'), 5);
						}
					}
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
				if($Ordering){//直接仕入の場合は発注データが無い
					foreach($Ordering['OrderingsDetail'] as $OrderingsDetail){//発注数量と入荷数量を比べて、入荷数量が多いか同じで発注ステータスを完了にする。
						if($OrderingsDetail['ordering_quantity'] > $OrderingsDetail['stock_quantity']){
							$ordering_jugement = false;
						}
					}
				}else{
					$ordering_jugement = false;
					
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
				if(!$mimus_result){
					$Purchase['Purchase']['remark'] = '※仕入返品しましたが指定倉庫に在庫がなかったので、在庫を減らしていない品番があります。';
				}
				if($return_juge){
					$Purchase['Purchase']['purchase_status'] = 5;
				}
				$this->Purchase->save($Purchase);
				$this->Session->delete("Purchase");
				$this->Session->delete("PurchaseDetail");
				$this->Session->setFlash('仕入（または返品）が完了しました。');
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
<?php
class InventoryDetailsController extends AppController {

	var $name = 'InventoryDetails';
	var $helpers = array('Html', 'Form');
	var $uses = array('InventoryDetail', 'Inventory', 'Depot', 'Subitem', 'Stock');
	var $components = array('OutputCsv');

	function index($inventory_id = null) {
		if (!$inventory_id) {
			$this->Session->setFlash(__('Invalid InventoryDetail.', true));
			$this->redirect(array('controller'=>'top', 'action'=>'index'));
		}
		$conditions = array();
		$modelName = 'InventoryDetail';
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['id'])){
				$conditions[] = array('and'=>array($modelName.'.id'=>$this->data[$modelName]['id']));
			}
			if(!empty($this->data[$modelName]['depot_id'])){
				$conditions[] = array('and'=>array($modelName.'.depot_id'=>$this->data[$modelName]['depot_id']));
			}
			if(!empty($this->data[$modelName]['jan'])){
				$conditions[] = array('and'=>array($modelName.'.jan'=>$this->data[$modelName]['jan']));
			}
			if(!empty($this->data[$modelName]['span'])){
				$conditions[] = array('and'=>array($modelName.'.span'=>$this->data[$modelName]['span']));
			}
			if(!empty($this->data[$modelName]['face'])){
				$conditions[] = array('and'=>array($modelName.'.face'=>$this->data[$modelName]['face']));
			}
			if(!empty($this->data[$modelName]['created_user'])){
				$conditions[] = array('and'=>array($modelName.'.created_user'=>$this->data[$modelName]['created_user']));
			}
			$conditions[] = array('and'=>array($modelName.'.inventory_id'=>$inventory_id));
			
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
					'order'=>array('InventoryDetail.id'=>'desc'),
					'contain'=>array('Depot', 'Subitem'),
				);
				$values = $this->InventoryDetail->find('all' ,$params);
				$values = $this->InventoryDetail->addStock($values);
				if($this->data[$modelName]['csv_diff'] == 1){
					$output_csv = $this->OutputCsv->InventoryDetail2($values);
				}else{
					$output_csv = $this->OutputCsv->InventoryDetail($values);
				}
				$file_name = 'InventoryDetail'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
		}else{
			$conditions[] = array('and'=>array($modelName.'.inventory_id'=>$inventory_id));
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>300,
			'order'=>array('InventoryDetail.id'=>'desc'),
			'recursive'=>0,
			'contain'=>array('Depot', 'Subitem'),
		);
		$inventoryDetails = $this->paginate();
		$inventoryDetails = $this->InventoryDetail->addStock($inventoryDetails);
		$this->set('inventoryDetails', $inventoryDetails);
		$this->Inventory->recursive = -1;
		$this->set('inventoryStatus', $this->Inventory->read(array('status') ,$inventory_id));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid InventoryDetail.', true));
			$this->redirect(array('action'=>'/'));
		}
		$this->set('inventoryDetail', $this->InventoryDetail->read(null, $id));
	}

	function add($id = null) {
		if($id) $this->data['Inventory']['id'] = $id;
		if (!empty($this->data)) {
			if(!empty($this->data['InventoryDetail']['depot'])){//depotが入っていたら倉庫名を入れる
				$this->data['InventoryDetail']['depot'] = mb_convert_kana($this->data['InventoryDetail']['depot'], 'a', 'UTF-8');
				$this->data['InventoryDetail']['depot'] = ereg_replace("[^0-9]", "", $this->data['InventoryDetail']['depot']);//半角数字以外を削除
				//どこの倉庫でも棚卸できるようにする仕様だから、要らないんだ
				/*
				$params = array(
					'conditions'=>array('Inventory.id'=>$this->data['Inventory']['id']),
					'recursive'=>-1
				);
				$Inventory = $this->Inventory->find('first' ,$params);
				if($this->Section->relationConfirm($Inventory['Inventory']['section_id'], $this->data['InventoryDetail']['depot'])){
					
				}else{
					$this->Session->setFlash(__('先に倉庫番号を入力して下さい。', true));
				}
				*/
				$this->data['InventoryDetail']['depot_name'] = $this->Depot->getName($this->data['InventoryDetail']['depot']);
			}elseif(!empty($this->params['form']['input1'])){//depotが入っていないのに、janが入っていたらエラー
				$this->Session->setFlash(__('先に倉庫番号を入力して下さい。', true));
			}
			//オレオレサニタイズ
			if(!empty($this->data['InventoryDetail']['span'])){
				$this->data['InventoryDetail']['span'] = mb_convert_kana($this->data['InventoryDetail']['span'], 'a', 'UTF-8');
				$this->data['InventoryDetail']['span'] = ereg_replace("[^0-9]", "", $this->data['InventoryDetail']['span']);//半角数字以外を削除
			}
			if(!empty($this->data['InventoryDetail']['face'])){
				$this->data['InventoryDetail']['face'] = mb_convert_kana($this->data['InventoryDetail']['face'], 'a', 'UTF-8');
				$this->data['InventoryDetail']['face'] = ereg_replace("[^0-9]", "", $this->data['InventoryDetail']['face']);//半角数字以外を削除
			}
			//JANコードをバリデーション
			if(!empty($this->params['form']['input1'])){
				$this->params['form']['input1'] = mb_convert_kana($this->params['form']['input1'], 'a', 'UTF-8');
				$this->params['form']['input1'] = ereg_replace("[^0-9]", "", $this->params['form']['input1']);
				if(strlen($this->params['form']['input1']) != 13) $this->params['form']['input1'] = null;//13文字以外は却下
			}
			//倉庫とjanが入っていたら追加
			if(!empty($this->data['InventoryDetail']['depot']) AND !empty($this->params['form']['input1'])){
				$params = array(
					'conditions'=>array('Subitem.jan'=>$this->params['form']['input1']),
					'recursive'=>0
				);
				$subitem = $this->Subitem->find('first' ,$params);
				if($subitem){
					if($this->Session->check('InventoryDetail')){
						$session_reader = $this->Session->read('InventoryDetail');
						if(!empty($session_reader[$subitem['Subitem']['id']])){
							$session_reader[$subitem['Subitem']['id']]['quantity'] = $session_reader[$subitem['Subitem']['id']]['quantity'] +1;
							$views_qty = $session_reader[$subitem['Subitem']['id']]['quantity'];
							$this->Session->setFlash($subitem['Subitem']['name'].__('は1加算し、<b>'.$views_qty.'</b>になりました。', true));
						}else{
							$session_reader[$subitem['Subitem']['id']]['quantity'] = 1;
						}
					}else{
						$session_reader[$subitem['Subitem']['id']]['quantity'] = 1;
					}
					$session_reader[$subitem['Subitem']['id']]['subitem_name'] = $subitem['Subitem']['name'];
					$session_reader[$subitem['Subitem']['id']]['subitem_jan'] = $subitem['Subitem']['jan'];
					$session_reader[$subitem['Subitem']['id']]['subitem_id'] = $subitem['Subitem']['id'];
					$session_reader[$subitem['Subitem']['id']]['item_id'] = $subitem['Item']['id'];
					$session_reader[$subitem['Subitem']['id']]['inventory_id'] = $this->data['Inventory']['id'];
					$session_reader[$subitem['Subitem']['id']]['depot_id'] = $this->data['InventoryDetail']['depot'];
					$session_reader[$subitem['Subitem']['id']]['span'] = $this->data['InventoryDetail']['span'];
					$session_reader[$subitem['Subitem']['id']]['face'] = $this->data['InventoryDetail']['face'];
					$this->Session->write("InventoryDetail", $session_reader);
					$this->set('Details',$session_reader);
				}
			}
		}
		$session_reader = $this->Session->read('InventoryDetail');
		if($session_reader){
			if(!empty($this->params['data']['InventoryDetail']['Qty'])){
				foreach($this->params['data']['InventoryDetail']['Qty'] as $subitem_id=>$quantity){
					foreach($session_reader as $key=>$value){
						if($subitem_id == $key AND $quantity != $value['quantity']){
							$session_reader[$key]['quantity'] = $quantity;
						}
					}
				}
			}
			$this->Session->write("InventoryDetail", $session_reader);
			$this->set('Details',$session_reader);
		}
	}
	
	//セッションクリア
	function reset($id = null){
		$this->Session->delete("Inventory");
		$this->Session->delete("InventoryDetail");
		$this->redirect(array('action'=>'add', $id));
	}
	
	//棚卸入力
	function input(){
		$session_reader = $this->Session->read('InventoryDetail');
		//quantity0が入ってきたら削除
		$total = 0;
		foreach($session_reader as $key=>$value){
			if($value['quantity'] == 0){
				unset($session_reader[$key]);
			}
			$inventory_id = $value['inventory_id'];
			$total = $total + $value['quantity'];
		}
		//重複があれば加算、無ければ新規登録
		if($this->InventoryDetail->newInput($session_reader, $this->Auth->user('id'))){
			$this->Session->setFlash(__($total.'点を棚卸入力しました。', true));
		}else{
			$this->Session->setFlash(__('ERROR:inventory_details_controller.php 111', true));
		}
		$this->Session->delete("Inventory");
		$this->Session->delete("InventoryDetail");
		$this->redirect(array('action'=>'add', $inventory_id));
		
	}
	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid InventoryDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->InventoryDetail->save($this->data)) {
				$this->Session->setFlash(__('The InventoryDetail has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The InventoryDetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InventoryDetail->read(null, $id);
		}
		$inventories = $this->InventoryDetail->Inventory->find('list');
		$depots = $this->InventoryDetail->Depot->find('list');
		$items = $this->InventoryDetail->Item->find('list');
		$subitems = $this->InventoryDetail->Subitem->find('list');
		$this->set(compact('inventories','depots','items','subitems'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for InventoryDetail', true));
			$this->redirect(array('action'=>'index'));
		}
		$detail = $this->InventoryDetail->findbyId($id);
		if ($this->InventoryDetail->del($id)) {
			$this->Session->setFlash(__('InventoryDetail deleted', true));
			$this->redirect(array('action'=>'index', $detail['Inventory']['id']));
		}
	}

}
?>
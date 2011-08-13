<?php
class InventoriesController extends AppController {

	var $name = 'Inventories';
	var $helpers = array('Html', 'Form');

	function index() {
		$conditions = array();
		if (!empty($this->data['Inventory']['section_id']) or !empty($this->data['Inventory']['status'])) {
			$this->data['Inventory']['section_id'] = mb_convert_kana($this->data['Inventory']['section_id'], 'a', 'UTF-8');
			$this->data['Inventory']['section_id'] = ereg_replace("[^0-9]", "", $this->data['Inventory']['section_id']);//半角数字以外を削除;
			$section_id = $this->data['Inventory']['section_id'];
			$seach_status = $this->data['Inventory']['status'];
			if(!empty($section_id)) $conditions['AND'][] = array('Inventory.section_id'=>$section_id);
			if(!empty($seach_status)) $conditions['AND'][] = array('Inventory.status'=>$seach_status);
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>50,
			'order'=>array('Inventory.updated'=>'desc')
		);
		$this->set('inventories', $this->paginate());
		$this->set('status', get_inventory_status());
	}

	function view($id = null, $depot_id = null, $ac = null){
		if (!$id) {
			$this->Session->setFlash(__('Invalid Inventory.', true));
			$this->redirect(array('action'=>'index'));
		}
		if(!empty($this->data)){
			$result = $this->Inventory->InventoryFinish($id, $this->data);
			//終了処理を隠す
			//resultファイルとか出力できるといいかもねー
			if($result){
				$this->Inventory->create();
				$data['Inventory']['id'] = $id;
				$data['Inventory']['status'] = 2;
				$this->Inventory->save($data);
			}
		}
		$params = array(
			'conditions'=>array('Inventory.id'=>$id),
			'recursive'=>0,
			'contain'=>array('Section')
		);
		$Inventory = $this->Inventory->find('first' ,$params);
		$this->set('inventory', $Inventory);
		$this->set('depots', $this->Inventory->viewsTotal($id));
		$this->set('status', get_inventory_status());
		if($ac == 'full'){//stockとinventDetailを全部ごっそりだして、整形して出力する
			$output_csv = $this->Inventory->outPutDepot($id, $depot_id);
			$file_name = 'Full_DepotId_'.$depot_id.'_Date_'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/';//一時データ保管場所
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
		}
		if($ac == 'diff'){//stockとinventDetailを全部ごっそりだして、整形して出力する
			$output_csv = $this->Inventory->outPutDepot2($id, $depot_id);
			$file_name = 'Diff_DepotId_'.$depot_id.'_Date_'.date('Ymd-His').'.csv';
			$path = WWW_ROOT.'/files/user_csv/';//一時データ保管場所
			$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
			file_put_contents($path.$file_name, $output_csv);
			$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
			$output['name'] = $file_name;
			$this->set('csv', $output);
		}
	}
	
	//倉庫単位に帳簿数と実棚数を合わせて表示する
	function output_depot($detail_id = null, $depot_id = null){
		//$this->render('view');
		if (!$depot_id OR !$detail_id) {
			$this->Session->setFlash(__('Invalid Inventory.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		$output_csv = $this->Inventory->outPutDepot($detail_id, $depot_id);
		
		
		//$this->view($detail_id);
		$this->redirect(array('action'=>'view/'.$detail_id));
	}
	

//	viewは消した ←あるじゃん？
	function add() {
		$section_id = $this->Auth->user('section_id');
		if($this->Inventory->statusCheck($section_id)){//同部門で棚卸中が無いか調べる
			$this->Inventory->create();
			$data['Inventory']['section_id'] = $section_id;
			$data['Inventory']['status'] = 1;
			$this->Inventory->save($data);
			//同部門で移動中があったら警告する
			
		}else{
			$this->Session->setFlash(__('ERROR:現在、棚卸中の為、新しい棚卸は追加できません。', true));
		}
		$this->redirect(array('action'=>'index'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Inventory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Inventory->save($this->data)) {
				$this->Session->setFlash(__('The Inventory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Inventory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Inventory->read(null, $id);
		}
		$sections = $this->Inventory->Section->find('list');
		$this->set(compact('sections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Inventory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inventory->del($id)) {
			$this->Session->setFlash(__('Inventory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
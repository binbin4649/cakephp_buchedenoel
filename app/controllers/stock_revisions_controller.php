<?php
class StockRevisionsController extends AppController {

	var $name = 'StockRevisions';
	var $uses = array('StockRevision', 'Subitem', 'Depot', 'Stock');
	var $components = array('DateilSeach', 'OutputCsv');

	function index() {
		$modelName = 'StockRevision';
		$conditions = array();
		if (!empty($this->data)) {
			if(!empty($this->data[$modelName]['created_start']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['created_start']);
				$conditions[] = array('and'=>array($modelName.'.created >='=>$date));
			}
			if(!empty($this->data[$modelName]['created_end']['year'])){
				$date = $this->DateilSeach->dateSqlArray($this->data[$modelName]['created_end']);
				$date .= $date.' 23:59:59';
				$conditions[] = array('and'=>array($modelName.'.created <='=>$date));
			}
			if(!empty($this->data[$modelName]['subitem'])) $conditions[] = array('and'=>array('Subitem.name LIKE'=>'%'.$this->data[$modelName]['subitem'].'%'));
			if(!empty($this->data[$modelName]['depot'])) $conditions[] = array('and'=>array('Depot.id'=>$this->data[$modelName]['depot']));
			if(!empty($this->data[$modelName]['stock_change'])) $conditions[] = array('and'=>array('StockRevision.stock_change'=>$this->data[$modelName]['stock_change']));
			if(!empty($this->data[$modelName]['reason_type'])) $conditions[] = array('and'=>array('StockRevision.reason_type'=>$this->data[$modelName]['reason_type']));
			if(empty($this->data[$modelName]['csv'])) $this->data[$modelName]['csv'] = 0;
			if($this->data[$modelName]['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
				);
				$StockRevisions = $this->StockRevision->find('all' ,$params);
				$output_csv = $this->OutputCsv->StockRevisions($StockRevisions);
				$file_name = 'StockRevision_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/';
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/'.SITE_DIR.'/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data[$modelName]['csv'] = null;
			}
			$this->Session->write($modelName.".conditions", $conditions);
			$this->Session->write($modelName.".search", $this->data);
		}else{
			if(empty($this->params['named']['page'])) $this->Session->delete($modelName);
		}
		if($this->Session->check($modelName)){
			$conditions = $this->Session->read($modelName.'.conditions');
			$this->data = $this->Session->read($modelName.'.search');
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>60,
			'order'=>array('StockRevision.created'=>'desc')
		);
		$this->StockRevision->recursive = 0;
		$this->set('stockRevisions', $this->paginate());
		$reason_type = get_reason_type();
		$stock_change =get_stock_change();
		$this->set(compact('reason_type', 'stock_change'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid StockRevision.', true));
			$this->redirect(array('action'=>'index'));
		}
		$view = $this->StockRevision->read(null, $id);
		$params = array(
			'conditions'=>array('Depot.id'=>$view['StockRevision']['depot_id']),
			'recursive'=>0
		);
		$depot = $this->Depot->find('first' ,$params);
		$this->set('stockRevision', $view);
		$reason_type = get_reason_type();
		$stock_change =get_stock_change();
		$this->set(compact('reason_type', 'stock_change', 'depot'));
	}

	function confirm(){
		$view = $this->data;
		$depot_id = $view['StockRevision']['depot_id'];
		$depot_id = mb_convert_kana($depot_id, 'a', 'UTF-8');
		$depot_id = ereg_replace("[^0-9]", "", $depot_id);//半角数字以外を削除
		$params = array(
			'conditions'=>array('Depot.id'=>$depot_id),
			'recursive'=>0
		);
		$is_depot = $this->Depot->find('first' ,$params);
		if(!$is_depot){
			$this->Session->setFlash($depot_id.' : そんな倉庫番号はありません。');
			$this->redirect(array('action'=>'add/'.$view['StockRevision']['subitem_id']));
		}
		$this->set('stockRevision', $view);
		$params = array(
			'conditions'=>array('Subitem.id'=>$view['StockRevision']['subitem_id']),
			'recursive'=>0
		);
		$subitem = $this->Subitem->find('first' ,$params);
		$depot = $this->Depot->sectionMarge($depot_id);
		$reason_type = get_reason_type();
		$stock_change =get_stock_change();
		$this->set(compact('reason_type', 'stock_change', 'subitem', 'depot'));
	}

	function add($id = null) {
		if (!empty($this->data)) {
			$depot = $this->data['StockRevision']['depot_id'];
			$subitem_id = $this->data['StockRevision']['subitem_id'];
			$quantity = $this->data['StockRevision']['quantity'];
			$user_id = $this->data['StockRevision']['created_user'];
			//単品管理で既に在庫が有る場合は、増できない。
			if($this->data['StockRevision']['stock_change'] == 1){
				if($this->Stock->only1check($subitem_id)){
				}else{
					$this->Session->setFlash(__('Management can not be increased more than one item separately.', true));
					$this->redirect(array('controller'=>'subitems', 'action'=>'view/'.$subitem_id));
				}
			}
			$this->StockRevision->create();
			if ($this->StockRevision->save($this->data)) {
				$StockRevision_id = $this->StockRevision->getInsertID();
				if($this->data['StockRevision']['stock_change'] == 1){
					$this->Stock->Plus($subitem_id, $depot, $quantity, $user_id, 3);
				}elseif($this->data['StockRevision']['stock_change'] == 2){
					$result = $this->Stock->Mimus($subitem_id, $depot, $quantity, $user_id, 3);
					if($result == false){
						$this->Session->setFlash(__('An inventory does not seem to be enough.', true));
						$this->redirect(array('action'=>'add/'.$subitem_id));
					}
				}
				$this->Session->setFlash(__('The StockRevision has been saved', true));
				$this->redirect(array('action'=>'view/'.$StockRevision_id));
			} else {
				$this->Session->setFlash(__('The StockRevision could not be saved. Please, try again.', true));
			}
		}
		$params = array(
			'conditions'=>array('Subitem.id'=>$id),
			'recursive'=>0
		);
		$subitem = $this->Subitem->find('first' ,$params);
		$params = array(
			'conditions'=>array('Depot.section_id'=>$this->Auth->user('section_id')),
			'recursive'=>0
		);
		$section_depots = $this->Depot->find('list' ,$params);
		foreach($section_depots as $key=>$value){
			$section_depots[$key] = $value.':'.$key;
		}
		$reason_type = get_reason_type();
		$stock_change =get_stock_change();
		$this->set(compact('reason_type', 'stock_change', 'subitem', 'section_depots'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid StockRevision', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->StockRevision->save($this->data)) {
				$this->Session->setFlash(__('The StockRevision has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The StockRevision could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->StockRevision->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for StockRevision', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->StockRevision->del($id)) {
			$this->Session->setFlash(__('StockRevision deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
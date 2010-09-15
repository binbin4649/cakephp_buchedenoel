<?php
class RepairsController extends AppController {

	var $name = 'Repairs';
	var $uses = array('Repair', 'Section', 'Item');
	var $helpers = array('AddForm',"Javascript","Ajax");
	var $components = array('Cleaning', 'Print', 'OutputCsv');

	function index() {
		$this->Repair->recursive = 0;
		$modelName = 'Repair';
		if (!empty($this->data)) {
			$conditions = array();
			if(!empty($this->data[$modelName]['factory_id'])){
				//$this->data[$modelName]['id'] = mb_convert_kana($this->data[$modelName]['id'], 'a', 'UTF-8');
				$conditions[] = array('and'=>array('Repair.factory_id'=>$this->data[$modelName]['factory_id']));
			}
			if(!empty($this->data[$modelName]['section_id'])){
				$conditions[] = array('and'=>array('Repair.section_id'=>$this->data[$modelName]['section_id']));
			}
			if(!empty($this->data[$modelName]['control_number'])){
				$conditions[] = array('and'=>array('Repair.control_number LIKE'=>'%'.$this->data[$modelName]['control_number'].'%'));
			}
			if(!empty($this->data[$modelName]['customer_name'])){
				$conditions[] = array('and'=>array('Repair.customer_name LIKE'=>'%'.$this->data[$modelName]['customer_name'].'%'));
			}
			if(!empty($this->data[$modelName]['status'])){
				$conditions[] = array('and'=>array('Repair.status'=>$this->data[$modelName]['status']));
			}
			if(!empty($this->data[$modelName]['estimate_status'])){
				$conditions[] = array('and'=>array('Repair.estimate_status'=>$this->data[$modelName]['estimate_status']));
			}
			if(!empty($this->data[$modelName]['brand_id'])){
				$conditions[] = array('and'=>array('Item.brand_id'=>$this->data[$modelName]['brand_id']));
			}
			if(!empty($this->data[$modelName]['item_id'])){
				$conditions[] = array('and'=>array('Item.id'=>$this->data[$modelName]['item_id']));
			}
			if($this->data['Repair']['csv'] == 1){
				$params = array(
					'conditions'=>$conditions,
				);
				$repairs = $this->Repair->find('all' ,$params);
				$output_csv = $this->OutputCsv->repairs($repairs);
				$file_name = 'repair_csv'.date('Ymd-His').'.csv';
				$path = WWW_ROOT.'/files/user_csv/'; //どうせ一時ファイルなんだから同じでいいや。ってことはフォルダ名はミスだね。でも面倒だからこのままで。
				$output_csv = mb_convert_encoding($output_csv, 'SJIS', 'UTF-8');
				file_put_contents($path.$file_name, $output_csv);
				$output['url'] = '/buchedenoel/files/user_csv/'.$file_name;
				$output['name'] = $file_name;
				$this->set('csv', $output);
				$this->data['Repair']['csv'] = null;
			}
			$this->Session->write("Repair.conditions", $conditions);
			$this->Session->write("Repair.search", $this->data);
		}else{
			$conditions[] = array('and'=>array('Repair.status <>'=>9));
			if(empty($this->params['named']['page'])) $this->Session->delete("Repair");
		}

		if($this->Session->check('Repair')){
			$conditions = $this->Session->read('Repair.conditions');
			$this->data = $this->Session->read('Repair.search');
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'limit'=>50,
			'order'=>array('Repair.created'=>'desc'),
			'recursive'=>1
		);
		$repairs = $this->paginate();
		foreach($repairs as $key=>$repair){
			$repairs[$key]['Section']['name'] = $this->Cleaning->sectionName($repair['Section']['name']);
			$repair['Factory']['name'] = $this->Cleaning->factoryName($repair['Factory']['name']);
			$repairs[$key]['Factory']['name'] = mb_substr($repair['Factory']['name'], 0, 8);
			$repairs[$key]['Repair']['customer_name'] = mb_substr($repair['Repair']['customer_name'], 0, 8);
			$repairs[$key]['Repair']['reception_date'] = mb_substr($repair['Repair']['reception_date'], 5, 5);
			$repairs[$key]['Repair']['store_arrival_date'] = mb_substr($repair['Repair']['store_arrival_date'], 5, 5);
			$repairs[$key]['Repair']['factory_delivery_date'] = mb_substr($repair['Repair']['factory_delivery_date'], 5, 5);
			$repairs[$key]['Repair']['shipping_date'] = mb_substr($repair['Repair']['shipping_date'], 5, 5);
			if(empty($repair['Repair']['control_number'])){
				$repairs[$key]['Repair']['control_number'] = '*';
			}
		}
		$this->set('sections', $this->Section->cleaningList());
		$this->set('brands', $this->Item->Brand->find('list'));
		$this->set('repairs', $repairs);
		$this->set('repairStatus', get_repair_status());
		$this->set('estimateStatus', get_estimate_status());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Repair.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('repair', $this->Repair->read(null, $id));
		$this->set('repairStatus', get_repair_status());
		$this->set('estimateStatus', get_estimate_status());
	}

	function add() {
		if (!empty($this->data)) {
			$this->Repair->create();
			$params = array(
				'conditions'=>array('Item.name'=>$this->data['Repair']['AutoItemName']),
				'recursive'=>0,
			);
			$item = $this->Item->find('first' ,$params);
			if($item){
				$this->data['Repair']['status'] = 1;
				$this->data['Repair']['item_id'] = $item['Item']['id'];
				$this->data['Repair']['factory_id'] = $item['Item']['factory_id'];
				if ($this->Repair->save($this->data)) {
					$repair_id = $this->Repair->getInsertID();
					$this->Session->setFlash(__('The Repair has been saved', true));
					$this->redirect(array('action'=>'view/'.$repair_id));
				} else {
					$this->Session->setFlash(__('The Repair could not be saved. Please, try again.', true));
				}
			}else{
				$this->Session->setFlash('品番は正確に入力してください。');
			}
		}
		$user = $this->Auth->user();
		$this->set('user', $user);
		$params = array(
			'conditions'=>array('Section.id'=>$user['User']['section_id']),
			'recursive'=>0,
		);
		$this->set('section', $this->Section->find('first' ,$params));
		$this->set('RepairStatus', get_repair_status());
		$this->set('EstimateStatus', get_estimate_status());
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Repair', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Repair->save($this->data)) {
				$this->Session->setFlash(__('The Repair has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Repair']['id']));
			} else {
				$this->Session->setFlash(__('The Repair could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Repair->read(null, $id);
		}
		$this->set('RepairStatus', get_repair_status());
		$this->set('EstimateStatus', get_estimate_status());
	}

	function store_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Repair', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Repair->save($this->data)) {
				$this->Session->setFlash(__('The Repair has been saved', true));
				$this->redirect(array('action'=>'view/'.$this->data['Repair']['id']));
			} else {
				$this->Session->setFlash(__('The Repair could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Repair->read(null, $id);
		}
		$this->set('RepairStatus', get_repair_status());
		$this->set('EstimateStatus', get_estimate_status());
	}

	function getData(){
		$this->layout = 'ajax';
		$params = array(
			'conditions'=>array('Item.name LIKE'=>'%'.$this->data['Repair']['AutoItemName'].'%'),
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
			$Autoitems[] = 'しらんがな';
		}
		$this->set("Autoitems",$Autoitems);
	}

	function requestprint($ac = null){
		$path = WWW_ROOT.'/files/repair-request/';
		if($ac == 'output'){
			$params = array(
				'conditions'=>array('Repair.status'=>2),
				'recursive'=>1,
			);
			$repairs = $this->Repair->find('all' ,$params);
			if($repairs){
				$file_name = 'repair-request-'.date('Ymd-His');
				$print_xml = $this->Print->RepairRequest($repairs, $file_name);
				file_put_contents($path.$file_name.'.php', $print_xml);
				$print_out['url'] = '/buchedenoel/files/repair-request/'.$file_name.'.php';
				$print_out['file'] = $file_name.'.pxd';
				$this->set('print', $print_out);
				foreach($repairs as $repair){
					$repair['Repair']['status'] = 3;
					$this->Repair->save($repair);
				}
			}
		}
		$old_file = array();
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if($file != '.' AND $file != '..'){
				$old_file[] = $file;
			}
		}
		closedir($handle);
		rsort($old_file, SORT_STRING);//ソート
		while(count($old_file) > 100){ //配列が100以上の場合は、末尾から順に削除
			array_pop($old_file);
		}
		reset($old_file);//配列のポインタを先頭に戻す
		$this->set('old_file', $old_file);
	}

	function head_check($id = null){
		$repair['Repair']['id'] = $id;
		$repair['Repair']['status'] = 2;
		$repair['Repair']['updated_user'] = $this->Auth->user('id');
		if($this->Repair->save($repair)){
			$this->Session->setFlash('状態を「本社確認」に更新しました。');
			$this->redirect(array('action'=>'view/'.$id));
		}else{
			$this->Session->setFlash('ERROR:repair207');
			$this->redirect(array('action'=>'index'));
		}
	}

	function arrival_factory($id = null){
		$repair['Repair']['id'] = $id;
		$repair['Repair']['status'] = 4;
		$repair['Repair']['updated_user'] = $this->Auth->user('id');
		if($this->Repair->save($repair)){
			$this->Session->setFlash('状態を「工場上がり」に更新しました。');
			$this->redirect(array('action'=>'view/'.$id));
		}else{
			$this->Session->setFlash('ERROR:repair223');
			$this->redirect(array('action'=>'index'));
		}
	}

	function ships_head($id = null){
		$repair['Repair']['id'] = $id;
		$repair['Repair']['status'] = 5;
		$repair['Repair']['updated_user'] = $this->Auth->user('id');
		if($this->Repair->save($repair)){
			$this->Session->setFlash('状態を「本社出荷」に更新しました。');
			$this->redirect(array('action'=>'view/'.$id));
		}else{
			$this->Session->setFlash('ERROR:repair228');
			$this->redirect(array('action'=>'index'));
		}
	}

	function arrival_store($id = null){
		$repair['Repair']['id'] = $id;
		$repair['Repair']['status'] = 6;
		$repair['Repair']['updated_user'] = $this->Auth->user('id');
		if($this->Repair->save($repair)){
			$this->Session->setFlash('状態を「店舗着」に更新しました。');
			$this->redirect(array('action'=>'view/'.$id));
		}else{
			$this->Session->setFlash('ERROR:repair235');
			$this->redirect(array('action'=>'index'));
		}
	}

	function complete($id = null){
		$repair['Repair']['id'] = $id;
		$repair['Repair']['status'] = 7;
		$repair['Repair']['updated_user'] = $this->Auth->user('id');
		if($this->Repair->save($repair)){
			$this->Session->setFlash('状態を「完了」に更新しました。');
			$this->redirect(array('action'=>'view/'.$id));
		}else{
			$this->Session->setFlash('ERROR:repair247');
			$this->redirect(array('action'=>'index'));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Repair', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Repair->del($id)) {
			$this->Session->setFlash(__('Repair deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>